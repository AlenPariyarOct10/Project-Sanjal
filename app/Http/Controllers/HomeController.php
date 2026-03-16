<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\College;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Popular Projects (Based on likes count)
        $popular_projects = Project::where('status', true)
            ->where('is_private', false)
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(6)
            ->get();

        // 2. Top Technologies (Most used tags)
        $top_technologies = Tag::withCount('projects')
            ->orderBy('projects_count', 'desc')
            ->take(10)
            ->get();

        // 3. Top Colleges (Colleges with most registered users/projects)
        // Since projects are linked to users, and users to colleges:
        $top_colleges = College::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(6)
            ->get();

        $total_projects = Project::count();
        $total_innovators = \App\Models\User::count();

        return view('welcome', compact('popular_projects', 'top_technologies', 'top_colleges', 'total_projects', 'total_innovators'));
    }
}
