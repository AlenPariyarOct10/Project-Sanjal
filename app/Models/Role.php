<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $fillable = ['title', 'slug', 'key', 'status'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
