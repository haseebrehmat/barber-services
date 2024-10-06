<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_slug',
        'product_old_price',
        'product_current_price',
        'product_stock',
        'product_content',
        'product_content_short',
        'product_return_policy',
        'product_featured_photo',
        'product_order',
        'product_status',
        'seo_title',
        'seo_meta_description',
        'product_category_id',
        'variant_id',
        'variant_options'
    ];

    protected $casts = [
        'variant_options' => 'array',
    ];

    public function setVariantOptionsAttribute($value)
    {
        $this->attributes['variant_options'] = json_encode(array_map('intval', $value));
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class)->withTrashed();
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class)->withTrashed();
    }

    public function modifiers()
    {
        return $this->belongsToMany(Modifier::class, 'products_modifiers', 'product_id', 'modifier_id');
    }
}
