<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlgorithmTag extends Model
{
    protected $table = 'algorithm_tags';
    protected $fillable = ['id', 'algorithm_id', 'tag_id', 'status', 'created_at', 'updated_at'];

    public function algorithm()
    {
        return $this->belongsTo(Algorithm::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

}
