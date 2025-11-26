<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model
{
    protected $table = 'project_tag';

    protected $fillable = [
        'project_id',
        'tag_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
