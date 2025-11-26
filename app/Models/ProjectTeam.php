<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    protected $table = 'project_team';

    protected $fillable = [
        'project_id',
        'team_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
