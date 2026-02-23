<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlgorithmCategory extends Model
{
    protected $table = 'algorithm_categories';
    protected $fillable = ['type', 'name', 'description', 'slug', 'key', 'status', 'deleted_at'];

    public function algorithms()
    {
        return $this->belongsToMany(Algorithm::class , 'algorithm_algorithm_category', 'algorithm_category_id', 'algorithm_id');
    }
}
