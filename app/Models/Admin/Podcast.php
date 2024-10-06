<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $table = 'podcasts';
    protected $fillable = [
        'image',
        'title',
        'sound',
        'link',
        'upload_type'
    ];

}
