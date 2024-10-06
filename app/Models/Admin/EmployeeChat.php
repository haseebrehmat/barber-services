<?php

namespace App\Models\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Model;

class EmployeeChat extends Model
{
    protected $fillable = [
        'employee_id',
        'msg',
        'sent_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Admin::class, 'employee_id');
    }
}
