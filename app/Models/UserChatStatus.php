<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserChatStatus extends Model
{
    use SoftDeletes;
    protected $table = 'user_chat_statuses';

    protected $fillable = [
        'title',
        'active',
        'hex'
    ];


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Str::lower($value);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->orderBy('updated_at', 'DESC');
    }

    public function landingPageContacts()
    {
        return $this->hasMany(LandingPageContact::class, 'user_chat_status_id');
    }

    
}
