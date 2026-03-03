<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tags';
    protected $fillable = ['name', 'slug', 'key', 'status'];

    // ---- Relationships ----

    public function projects()
    {
        return $this->belongsToMany(Project::class , 'project_tag', 'tag_id', 'project_id');
    }

    public function algorithms()
    {
        return $this->belongsToMany(Algorithm::class , 'algorithm_tags', 'tag_id', 'algorithm_id');
    }
}
