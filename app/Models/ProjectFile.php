<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    protected $table = 'project_files';
    protected $fillable = ['name', 'file_path', 'file_type', 'project_id', 'created_by', 'is_public', 'status', 'updated_by', 'deleted_at', 'created_at', 'updated_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
