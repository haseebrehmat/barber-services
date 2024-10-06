<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    public $fillable = ['title', 'subtitle', 'currency', 'format', 'price', 'features', 'tick_cross'];

    protected $casts = [
        'features' => 'array',
        'tick_cross' => 'array',
    ];

}
