<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $with = ['recipients'];

    protected $fillable = ['name', 'description'];

    public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'recipients_tags', 'tags_id', 'recipients_id');
    }
}
