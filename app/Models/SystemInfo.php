<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemInfo extends Model
{
    protected $table = 'system_infos';

    protected $fillable = ['id', 'key', 'value', 'status', 'created_at', 'updated_at'];
}
