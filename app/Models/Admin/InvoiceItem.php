<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'qty',
        'unit_price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
