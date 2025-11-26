<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAlgorithm extends Model
{
    protected $table = 'project_algorithm';
    protected $fillable = ['project_id', 'algorithm_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function algorithm()
    {
        return $this->belongsTo(Algorithm::class);
    }
}
