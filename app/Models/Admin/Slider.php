<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'slider_heading',
        'slider_text',
        'slider_button_text',
        'slider_button_url',
        'slider_type',
        'slider_photo',
        'slider_video',
        'slider_mp4',
        'slider_color',
        'centered',
        'overlay',
        'page',
        'heading_color',     // Hex Code like #ffffff
        'heading_font_size', // Value in px
        'text_color',
        'text_font_size',
        'button_text_color',
        'button_bg_color',
        'button_text_font_size',
        'alignment',        // left, center, right
    ];

}
