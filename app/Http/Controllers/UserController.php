<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified user profile.
     */
    public function show($id)
    {
        $user = User::with(['college', 'teams'])->findOrFail($id);

        // Get all projects (own + team projects)
        $projects = $user->allProjects()
            ->where('status', true)
            ->where('is_private', false)
            ->with(['tags', 'likes'])
            ->latest()
            ->get();

        $totalLikes = $projects->sum(function ($project) {
            return $project->likes()->count();
        });

        return view('users.show', compact('user', 'projects', 'totalLikes'));
    }
}
