<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tag', 'project_id', 'tag_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'project_likes', 'project_id', 'user_id')
            ->withTimestamps();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'project_team', 'project_id', 'team_id');
    }

    public function algorithms()
    {
        return $this->belongsToMany(Subject::class, 'project_algorithm', 'project_id', 'algorithm_id');
    }
}
