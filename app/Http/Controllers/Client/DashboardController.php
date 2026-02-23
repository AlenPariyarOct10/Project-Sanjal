<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\ProjectFile;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard with statistics.
     */
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'total_projects' => Project::where('created_by', $userId)->count(),
            'total_likes' => Project::where('created_by', $userId)
            ->join('project_likes', 'projects.id', '=', 'project_likes.project_id')
            ->count(),
            'total_files' => ProjectFile::where('created_by', $userId)->count(),
            'public_projects' => Project::where('created_by', $userId)->where('is_private', false)->count(),
            'private_projects' => Project::where('created_by', $userId)->where('is_private', true)->count(),
        ];

        $recent_projects = Project::where('created_by', $userId)
            ->withCount('likes')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard.index', compact('stats', 'recent_projects'));
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
