<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Algorithm;
use App\Models\University;
use App\Models\College;
use App\Models\Team;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private function baseProjectQuery()
    {
        return Project::where(function ($q) {
            $q->where('created_by', auth()->id())
                ->orWhereHas('teams', function ($q2) {
                $q2->where('teams.created_by', auth()->id())
                    ->orWhereIn('teams.id', function ($sub) {
                    $sub->select('team_id')
                        ->from('team_members')
                        ->where('user_id', auth()->id())
                        ->where('status', 'approved');
                }
                );
            }
            );
        });
    }

    /**
     * Display a listing of the user's projects.
     */
    public function index(Request $request)
    {
        $query = $this->baseProjectQuery();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $projects = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('client.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $tags = Tag::where('status', true)->get();
        $courses = Course::where('status', true)->get();
        $algorithms = Algorithm::where('status', true)->get();
        $universities = University::where('status', true)->get();
        $colleges = College::where('status', true)->get();
        $teams = Team::where('created_by', auth()->id())->get();

        return view('client.projects.create', compact('tags', 'courses', 'algorithms', 'universities', 'colleges', 'teams'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'github_url' => 'nullable|url',
            'live_demo_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'algorithms' => 'nullable|array',
            'algorithms.*' => 'exists:algorithms,id',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id',
            // Documentation files: PDF, DOC, DOCX, PPT, PPTX — max 20MB each
            'documentation_files' => 'nullable|array',
            'documentation_files.*' => 'file|max:20480|mimes:pdf,doc,docx,ppt,pptx',
            // Source code files: ZIP, RAR, 7z — max 20MB each
            'source_files' => 'nullable|array',
            'source_files.*' => 'file|max:20480|mimes:zip,rar,7z',
        ], [
            'documentation_files.*.mimes' => 'Documentation files must be PDF, DOC, DOCX, PPT, or PPTX.',
            'documentation_files.*.max' => 'Each documentation file must not exceed 20MB.',
            'source_files.*.mimes' => 'Source code files must be ZIP, RAR, or 7Z archives.',
            'source_files.*.max' => 'Each source code file must not exceed 20MB.',
        ]);

        $project = new Project();
        $project->name = $request->name;
        $project->slug = Str::slug($request->name) . '-' . time();
        $project->description = $request->description;
        $project->github_url = $request->github_url;
        $project->live_demo_url = $request->live_demo_url;
        $project->course_id = $request->course_id;
        $project->subject_id = $request->subject_id;
        $project->is_private = $request->has('is_private');
        $project->created_by = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $project->image = $path;
        }

        $project->save();

        // Handle Tags
        if ($request->tags) {
            $project->tags()->sync($request->tags);
        }

        // Handle Algorithms
        if ($request->algorithms) {
            $project->algorithms()->sync($request->algorithms);
        }

        // Handle Teams
        if ($request->teams) {
            $project->teams()->sync($request->teams);
        }

        // Handle Documentation Files
        if ($request->hasFile('documentation_files')) {
            foreach ($request->file('documentation_files') as $file) {
                $path = $file->store('project_files/documentation', 'public');
                ProjectFile::create([
                    'project_id' => $project->id,
                    'name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_category' => 'documentation',
                    'created_by' => auth()->id(),
                ]);
            }
        }

        // Handle Source Code Files
        if ($request->hasFile('source_files')) {
            foreach ($request->file('source_files') as $file) {
                $path = $file->store('project_files/source', 'public');
                ProjectFile::create([
                    'project_id' => $project->id,
                    'name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_category' => 'source_code',
                    'created_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('client.projects.index')->with('success', 'Project submitted successfully!');
    }

    public function show($id)
    {
        $project = Project::with(['course', 'subject', 'algorithms', 'user.college', 'teams', 'tags', 'files'])
            ->where('id', $id)
            ->firstOrFail();

        $relatedProjects = Project::where('status', true)
            ->where('is_private', false)
            ->where('id', '!=', $project->id)
            ->where(function ($q) use ($project) {
            $q->where('course_id', $project->course_id)
                ->orWhere('subject_id', $project->subject_id);
        })
            ->latest()
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        $project = $this->baseProjectQuery()
            ->with(['tags', 'algorithms', 'teams', 'files'])
            ->where('id', $id)
            ->firstOrFail();

        $tags = Tag::where('status', true)->get();
        $courses = Course::where('status', true)->get();
        $subjects = Subject::where('course_id', $project->course_id)->get();
        $algorithms = Algorithm::where('status', true)->get();
        $universities = University::where('status', true)->get();
        $colleges = College::where('status', true)->get();
        $teams = Team::where('created_by', auth()->id())->get();

        return view('client.projects.edit', compact('project', 'tags', 'courses', 'subjects', 'algorithms', 'universities', 'colleges', 'teams'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, $id)
    {
        $project = $this->baseProjectQuery()
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'github_url' => 'nullable|url',
            'live_demo_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'algorithms' => 'nullable|array',
            'algorithms.*' => 'exists:algorithms,id',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id',
            'documentation_files' => 'nullable|array',
            'documentation_files.*' => 'file|max:20480|mimes:pdf,doc,docx,ppt,pptx',
            'source_files' => 'nullable|array',
            'source_files.*' => 'file|max:20480|mimes:zip,rar,7z',
        ], [
            'documentation_files.*.mimes' => 'Documentation files must be PDF, DOC, DOCX, PPT, or PPTX.',
            'documentation_files.*.max' => 'Each documentation file must not exceed 20MB.',
            'source_files.*.mimes' => 'Source code files must be ZIP, RAR, or 7Z archives.',
            'source_files.*.max' => 'Each source code file must not exceed 20MB.',
        ]);

        $project->name = $request->name;
        $project->description = $request->description;
        $project->github_url = $request->github_url;
        $project->live_demo_url = $request->live_demo_url;
        $project->course_id = $request->course_id;
        $project->subject_id = $request->subject_id;
        $project->is_private = $request->has('is_private');

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $path = $request->file('image')->store('projects', 'public');
            $project->image = $path;
        }

        $project->save();

        // Sync Relations
        $project->tags()->sync($request->tags ?? []);
        $project->algorithms()->sync($request->algorithms ?? []);
        $project->teams()->sync($request->teams ?? []);

        // Handle New Documentation Files
        if ($request->hasFile('documentation_files')) {
            foreach ($request->file('documentation_files') as $file) {
                $path = $file->store('project_files/documentation', 'public');
                ProjectFile::create([
                    'project_id' => $project->id,
                    'name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_category' => 'documentation',
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }
        }

        // Handle New Source Code Files
        if ($request->hasFile('source_files')) {
            foreach ($request->file('source_files') as $file) {
                $path = $file->store('project_files/source', 'public');
                ProjectFile::create([
                    'project_id' => $project->id,
                    'name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_category' => 'source_code',
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }
        }

        // Handle File Deletion (if any passed)
        if ($request->delete_files) {
            foreach ($request->delete_files as $fileId) {
                $file = ProjectFile::where('id', $fileId)->where('project_id', $project->id)->first();
                if ($file) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
            }
        }

        return redirect()->route('client.projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy($id)
    {
        $project = Project::where('id', $id)
            ->where('created_by', auth()->id())
            ->firstOrFail();

        // Delete Image
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        // Delete Files
        foreach ($project->files as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        $project->delete();

        return redirect()->route('client.projects.index')->with('success', 'Project deleted successfully!');
    }

    public function getSubjects($course_id)
    {
        $subjects = Subject::where('course_id', $course_id)->get(['id', 'name']);
        return response()->json($subjects);
    }
}
