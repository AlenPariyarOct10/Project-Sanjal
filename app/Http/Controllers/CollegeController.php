<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Project;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Display a listing of colleges.
     */
    public function index(Request $request)
    {
        $query = College::where('status', true);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('address', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('university')) {
            $query->where('university_id', $request->university);
        }

        $colleges = $query->with('university')->orderBy('name')->paginate(12)->withQueryString();
        $universities = \App\Models\University::where('status', true)->get();

        return view('colleges.index', compact('colleges', 'universities'));
    }

    /**
     * Display the specified college profile.
     */
    public function show(Request $request, $id)
    {
        $college = College::with(['university'])->findOrFail($id);

        // Fetch innovators (users) from this college
        $innovators = \App\Models\User::with('role')
            ->where('college_id', $id)
            ->where('status', true)
            ->paginate(10, ['*'], 'innovators_page')
            ->withQueryString();

        // Fetch valid filter items associated with this college's users' projects
        $filterCourses = \App\Models\Course::whereHas('projects', function ($q) use ($id) {
            $q->where('status', true)
                ->where('is_private', false)
                ->whereHas('user', function ($qu) use ($id) {
                $qu->where('college_id', $id);
            }
            );
        })->get();

        $filterSubjects = \App\Models\Subject::whereHas('projects', function ($q) use ($id) {
            $q->where('status', true)
                ->where('is_private', false)
                ->whereHas('user', function ($qu) use ($id) {
                $qu->where('college_id', $id);
            }
            );
        })->get();

        $filterAlgorithms = \App\Models\Algorithm::whereHas('projects', function ($q) use ($id) {
            $q->where('status', true)
                ->where('is_private', false)
                ->whereHas('user', function ($qu) use ($id) {
                $qu->where('college_id', $id);
            }
            );
        })->get();

        // Projects Query
        $projectsQuery = Project::where('status', true)
            ->where('is_private', false)
            ->whereHas('user', function ($query) use ($id) {
            $query->where('college_id', $id);
        });

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $projectsQuery->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $projectsQuery->where('course_id', $request->course_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $projectsQuery->where('subject_id', $request->subject_id);
        }

        // Filter by algorithm
        if ($request->filled('algorithm_id')) {
            $projectsQuery->whereHas('algorithms', function ($q) use ($request) {
                $q->where('algorithms.id', $request->algorithm_id);
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        if ($sort === 'popular') {
            $projectsQuery->withCount('likes')->orderByDesc('likes_count');
        }
        elseif ($sort === 'oldest') {
            $projectsQuery->oldest();
        }
        else {
            $projectsQuery->latest();
        }

        $projects = $projectsQuery->paginate(10, ['*'], 'projects_page')->withQueryString();

        $totalLikes = Project::where('status', true)
            ->where('is_private', false)
            ->whereHas('user', function ($query) use ($id) {
            $query->where('college_id', $id);
        })
            ->withCount('likes')
            ->get()
            ->sum('likes_count');

        return view('colleges.show', compact(
            'college', 'innovators', 'projects', 'totalLikes',
            'filterCourses', 'filterSubjects', 'filterAlgorithms'
        ));
    }
}
