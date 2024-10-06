<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CouponDesign extends Model
{
    protected $fillable = ['title', 'content', 'code', 'type', 'value', 'modified_by', 'thumbnail', 'expired_at'];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function scopeUnmodified($query)
    {
        return $query-> whereNull('modified_by')->orderBy('id');
    }

    public function scopeModified($query)
    {
        return $query-> where('modified_by', session('id'))->orderBy('id');
    }
}
