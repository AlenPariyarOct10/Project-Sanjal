<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['id', 'name', 'slug', 'key', 'status', 'deleted_at', 'created_at', 'updated_at'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_tag', 'tag_id', 'project_id');
    }
}
