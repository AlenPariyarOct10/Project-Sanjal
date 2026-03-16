<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    protected $table = 'project_files';
    protected $fillable = ['name', 'file_path', 'file_type', 'file_category', 'description', 'sort_order', 'project_id', 'created_by', 'is_public', 'status', 'updated_by', 'deleted_at', 'created_at', 'updated_at'];

    public function scopeScreenshots($query)
    {
        return $query->where('file_category', 'screenshot')->orderBy('sort_order');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
