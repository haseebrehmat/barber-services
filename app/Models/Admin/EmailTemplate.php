<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'et_subject',
        'et_content',
        'et_name',
        'et_type',
        'thumbnail',
        'modified_by'
    ];

    public function scopeUnmodified($query)
    {
        return $query->where('et_type', 'emailer')->whereNull('modified_by')->orderBy('id');
    }

    public function scopeModified($query)
    {
        return $query->where('et_type', 'emailer')->where('modified_by', session('id'))->orderBy('id');
    }

}
