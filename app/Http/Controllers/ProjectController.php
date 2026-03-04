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
