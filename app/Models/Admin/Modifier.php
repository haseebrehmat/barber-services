<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;

class Modifier extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'unit_price', 'thumbnail'];

    public function setThumbnailAttribute($value)
    {
        if (!is_null($value) && $value instanceof UploadedFile) {
            // Remove old thumbnail
            if ($this->thumbnail) {
                $file_path = public_path('uploads/') . $this->thumbnail;
                unlink($file_path);
            }

            // Upload Thumbnail
            $final_name = time() . '.' . $value->extension();
            $value->move(public_path('uploads/'), $final_name);
            $this->attributes['thumbnail'] = $final_name;
        }
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_modifiers', 'modifier_id', 'product_id');
    }
}
