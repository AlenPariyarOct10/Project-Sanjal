<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team', 'team_id', 'project_id');
    }
}
