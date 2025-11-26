<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'key', 'status', 'code', 'description', 'created_by', 'updated_by', 'university_id', 'deleted_at', 'created_at', 'updated_at' ];

    // Relationship: Course has many subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
