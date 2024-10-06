<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $with = ['items'];
    protected $fillable = [
        'number',
        'street',
        'city',
        'country',
        'state',
        'issue_date',
        'client_name',
        'client_email',
        'status',
        'tax'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
}
