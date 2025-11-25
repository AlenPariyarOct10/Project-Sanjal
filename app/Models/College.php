<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{

use SoftDeletes;

    protected $table = 'colleges';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'logo',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'description',
        'user_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
