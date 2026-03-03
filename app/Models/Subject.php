<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'course_id', 'description'];

    // ---- Relationships ----

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
