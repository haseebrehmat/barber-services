<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'musics';
    protected $fillable = [
        'image',
        'title',
        'sound',
        'link',
        'upload_type'
    ];

}
