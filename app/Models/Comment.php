<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';
    protected $fillable = ['text', 'user_id', 'project_id', 'parent_id'];

    // ---- Relationships ----

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
        return $this->belongsTo(Comment::class , 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class , 'parent_id');
    }
}
