<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id', 'title', 'slug', 'key', 'status', 'deleted_at', 'created_at', 'updated_at'];
}
