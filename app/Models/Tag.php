<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_tag', 'tag_id', 'project_id');
    }
}
