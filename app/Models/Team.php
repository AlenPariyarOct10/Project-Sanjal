<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $table = 'teams';
    protected $fillable = [
        'name', 'description', 'logo', 'website',
        'facebook', 'twitter', 'instagram', 'youtube', 'linkedin', 'created_by'
    ];

    // ---- Relationships ----

    public function projects()
    {
        return $this->belongsToMany(Project::class , 'project_team', 'team_id', 'project_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class , 'team_members', 'team_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
