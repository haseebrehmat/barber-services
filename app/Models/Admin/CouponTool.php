<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CouponTool extends Model
{
    protected $table = 'coupon_tools';
    protected $fillable = [
        'secret',
        'title',
        'valid_till',
        'hex',
        'image',
        'logo'
    ];
}
