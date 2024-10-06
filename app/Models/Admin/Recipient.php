<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['name', 'email', 'source'];

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaigns_recipients', 'recipients_id', 'campaigns_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'recipients_tags', 'recipients_id', 'tags_id');
    }

}
