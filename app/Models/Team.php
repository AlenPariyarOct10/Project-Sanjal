<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $table = 'teams';
    protected $fillable = ['id', 'name', 'description', 'logo', 'website', 'facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'deleted_at', 'created_at', 'updated_at'];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team', 'team_id', 'project_id');
    }
}
