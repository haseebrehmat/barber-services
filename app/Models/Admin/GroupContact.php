<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GroupContact extends Model
{
    protected $table = 'group_contacts';

    protected $fillable = ['group_id', 'name', 'email', 'phone'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
