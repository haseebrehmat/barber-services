<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    protected $table = "order_shippings";
    protected $fillable = ["code", "carrier", "shipper", "order_date", "shipping_date", "delivery_date", "pdf"];
}
