<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class , 'project_tag', 'project_id', 'tag_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class , 'project_likes', 'project_id', 'user_id')
            ->withTimestamps();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class , 'project_team', 'project_id', 'team_id');
    }

    public function algorithms()
    {
        return $this->belongsToMany(Algorithm::class , 'project_algorithm', 'project_id', 'algorithm_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class , 'project_id');
    }
}
