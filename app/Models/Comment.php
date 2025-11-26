<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected  $fillable = ['text', 'user_id', 'project_id', 'parent_id', 'created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
