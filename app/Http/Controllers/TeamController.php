<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function show(Team $team)
    {
        // Load approved members, creator, and related projects (where team_id is the pivot)
        $team->load(['members' => function ($query) {
            $query->wherePivot('status', 'approved');
        }, 'creator', 'projects' => function ($query) {
            // Include algorithm/tag relations if needed, but basic project info is fine
            $query->with(['tags']);
        }]);

        // Projects created directly by the team. Let's see how Team -> Projects is set up.
        // Wait, Project belongsToMany Team via project_team pivot!
        // The relationship is $team->projects. The load() above covers it.

        return view('teams.show', compact('team'));
    }
}
