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
    public function show($id)
    {
        $college = College::with(['university', 'users'])->findOrFail($id);

        // Fetch public projects associated with this college's users
        $projects = Project::where('status', true)
            ->where('is_private', false)
            ->whereHas('user', function ($query) use ($id) {
            $query->where('college_id', $id);
        })
            ->latest()
            ->paginate(12);

        $totalLikes = Project::where('status', true)
            ->where('is_private', false)
            ->whereHas('user', function ($query) use ($id) {
            $query->where('college_id', $id);
        })
            ->withCount('likes')
            ->get()
            ->sum('likes_count');

        return view('colleges.show', compact('college', 'projects', 'totalLikes'));
    }
}
