<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'course_id', 'description'];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_algorithm', 'algorithm_id', 'project_id');
    }
}
