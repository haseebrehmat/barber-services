<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\UploadedFile;

class Offering extends Model
{
    protected $fillable = [
        'name',
        'regular_rate',
        'appointed_rate',
        'photo',
        'details',
        'is_active',
    ];

    public function setPhotoAttribute($value)
    {
        if ($value instanceof UploadedFile) {
            $this->removePhoto();

            $ext = $value->extension();
            $finalName = time() . '.' . $ext;
            $value->move(public_path('uploads/'), $finalName);

            $this->attributes['photo'] = $finalName;
        } else {
            $this->attributes['photo'] = $value;
        }
    }

    protected function removePhoto()
    {
        if (!empty($this->attributes['photo'])) {
            $photoPath = public_path('uploads/') . $this->attributes['photo'];

            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }
    }
}
