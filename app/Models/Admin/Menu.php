<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'menu_key',
        'menu_name',
        'menu_status',
        'parent_id',
        'route',
        'fixed',
        'link',
    ];

    public function sub_menu()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
}
