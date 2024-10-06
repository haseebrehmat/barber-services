<?php

namespace App\Models\Admin;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerChat extends Model
{
    protected $fillable = [
        'customer_id',
        'msg',
        'sent_by',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
