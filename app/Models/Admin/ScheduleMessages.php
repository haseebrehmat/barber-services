<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ScheduleMessages extends Model
{
    protected $fillable = ['msg', 'scheduled_at', 'status', 'module', 'user_ids', 'type'];

    protected $casts = ['scheduled_at' => 'datetime'];
}
