<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'code', 'description'];

    // Relationship: Course has many subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
