<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\College;
use App\Models\University;
use App\Models\Algorithm;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_colleges' => College::count(),
            'total_universities' => University::count(),
            'total_algorithms' => Algorithm::count(),
            'total_courses' => Course::count(),
            'total_subjects' => Subject::count(),
        ];

        $recent_projects = Project::with(['user', 'course', 'subject'])
            ->latest()
            ->limit(5)
            ->get();

        $recent_users = User::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recent_projects', 'recent_users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    //
    }
}
