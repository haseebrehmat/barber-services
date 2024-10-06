<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PageShopItem extends Model
{
    protected $fillable = [
        'name',
        'content',
        'status',
        'seo_title',
        'seo_meta_description',
        'category_text_color',
        'category_background_color',
        'active_category_text_color',
        'active_category_background_color',
        'rounded_images'
    ];

}
