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

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with aggregate statistics.
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
}
