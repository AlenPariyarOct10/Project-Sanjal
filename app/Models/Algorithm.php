<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $table = 'algorithms';
    protected $fillable = [
        'id', 'name', 'slug', 'description', 'image', 'resource_url', 'key', 'status', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_algorithm', 'algorithm_id', 'project_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            AlgorithmCategory::class,
            'algorithm_algorithm_category',
            'algorithm_id',
            'algorithm_category_id'
        );
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'algorithm_tags', 'algorithm_id', 'tag_id');
    }
}
