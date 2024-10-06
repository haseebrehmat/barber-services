<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class StoreTiming extends Model
{
    protected $fillable = ['user_id', 'day', 'open_time', 'close_time', 'off_day'];

    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', session('id'))->orderBy('id');
    }
}
