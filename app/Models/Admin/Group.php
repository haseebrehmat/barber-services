<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'detail'];

    public function contacts()
    {
        return $this->hasMany(GroupContact::class, 'group_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($group) {
            $group->contacts()->delete();
        });
    }

}
