<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';
    protected $fillable = ['project_id', 'user_id', 'created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at'];

}
