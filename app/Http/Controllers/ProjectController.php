<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::where('status', true)
            ->where('is_private', false);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }

        if ($request->filled('algorithm')) {
            $query->whereHas('algorithms', function ($q) use ($request) {
                $q->where('algorithms.id', $request->algorithm);
            });
        }

        if ($request->filled('college')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('college_id', $request->college);
            });
        }

        if ($request->input('sort') === 'likes') {
            $query->withCount('likes')->orderByDesc('likes_count');
        }
        else {
            $query->latest();
        }

        $projects = $query->paginate(12)->withQueryString();

        $tags = \App\Models\Tag::where('status', true)->get();
        $courses = \App\Models\Course::where('status', true)->get();
        $subjects = \App\Models\Subject::get();
        $algorithms = \App\Models\Algorithm::where('status', true)->get();
        $colleges = \App\Models\College::where('status', true)->get();

        return view('projects.index', compact('projects', 'tags', 'courses', 'subjects', 'algorithms', 'colleges'));
    }

    public function show($slug)
    {
        $project = Project::with([
            'course', 'subject', 'algorithms', 'user.college', 'teams', 'tags', 'files',
            'comments' => function ($q) {
            $q->whereNull('parent_id')->with(['user', 'replies.user'])->latest();
        }
        ])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Increment view count
        $project->increment('views');

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

    public function download($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $files = $project->files()->where('status', true)->get();

        if ($files->isEmpty()) {
            return redirect()->back()->with('error', 'No file found for this project.');
        }

        // --- Single file: stream it directly ---
        if ($files->count() === 1) {
            $file = $files->first();
            $filePath = storage_path('app/public/' . $file->file_path);

            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File not found on server.');
            }

            $project->increment('downloads');

            return response()->download($filePath, $file->name ?? basename($filePath));
        }

        // --- Multiple files: build a ZIP in memory and stream it ---
        if (!class_exists('ZipArchive')) {
            return redirect()->back()->with('error', 'ZIP support is not available on this server.');
        }

        $zipFileName = \Illuminate\Support\Str::slug($project->name) . '-files.zip';
        $zipTmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipFileName;

        $zip = new \ZipArchive();
        if ($zip->open($zipTmpPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Could not create ZIP archive.');
        }

        $added = 0;
        foreach ($files as $file) {
            $filePath = storage_path('app/public/' . $file->file_path);
            if (file_exists($filePath)) {
                // Organise files into sub-folders by category
                $folder = match ($file->file_category) {
                        'documentation' => 'documentation/',
                        'source_code' => 'source_code/',
                        default => '',
                    };
                $zip->addFile($filePath, $folder . ($file->name ?? basename($filePath)));
                $added++;
            }
        }

        $zip->close();

        if ($added === 0) {
            @unlink($zipTmpPath);
            return redirect()->back()->with('error', 'No files found on server.');
        }

        $project->increment('downloads');

        return response()->download($zipTmpPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function toggleLike(Request $request, Project $project)
    {
        $user = auth()->guard('client')->user() ?? auth()->user();

        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['error' => 'You must be logged in to like a project.'], 401);
            }
            return redirect()->route('client.login')->with('error', 'You must be logged in to like a project.');
        }

        if ($project->likes()->where('user_id', $user->id)->exists()) {
            $project->likes()->detach($user->id);
            $isLiked = false;
        }
        else {
            $project->likes()->attach($user->id);
            $isLiked = true;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'isLiked' => $isLiked,
                'likesCount' => $project->likes()->count()
            ]);
        }

        return redirect()->back();
    }
}
