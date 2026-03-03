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
        // Load the user with their college, active projects, stats
        $user = User::with(['college', 'teams', 'projects' => function ($query) {
            $query->where('status', true)
                ->where('is_private', false)
                ->latest();
        }])->findOrFail($id);

        $totalLikes = $user->projects()
            ->where('status', true)
            ->where('is_private', false)
            ->withCount('likes')
            ->get()
            ->sum('likes_count');

        return view('users.show', compact('user', 'totalLikes'));
    }
}
