<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'universities';
    protected $fillable = [
        'name', 'description', 'address', 'phone', 'email',
        'logo', 'website', 'facebook', 'twitter', 'instagram',
        'youtube', 'linkedin', 'key', 'slug', 'status',
    ];

    // ---- Relationships ----

    public function colleges()
    {
        return $this->hasMany(College::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
