<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'title', 'location', 'url', 'icon', 'type',
        'parent_id', 'order', 'status',
    ];

    // ---- Relationships ----

    public function parent()
    {
        return $this->belongsTo(Menu::class , 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class , 'parent_id');
    }
}
