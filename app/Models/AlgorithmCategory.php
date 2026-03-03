<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlgorithmCategory extends Model
{
    use SoftDeletes;

    protected $table = 'algorithm_categories';
    protected $fillable = ['type', 'name', 'description', 'slug', 'key', 'status'];

    // ---- Relationships ----

    public function algorithms()
    {
        return $this->belongsToMany(
            Algorithm::class ,
            'algorithm_algorithm_category',
            'algorithm_category_id',
            'algorithm_id'
        );
    }
}
