<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'key', 'status', 'code', 'description',
        'created_by', 'updated_by', 'university_id',
    ];

    // ---- Relationships ----

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
