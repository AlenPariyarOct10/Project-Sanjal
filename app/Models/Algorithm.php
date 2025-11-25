<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $table = 'algorithms';

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_algorithm', 'algorithm_id', 'project_id');
    }
}
