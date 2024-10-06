<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public $with = ['recipients', 'template'];

    protected $fillable = ['name', 'template_id', 'status'];

    public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'campaigns_recipients', 'campaigns_id', 'recipients_id');
    }

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}
