<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPageContact extends Model
{
    use HasFactory;
    protected $table = 'landing_page_contacts';

    public function userChatStatus()
    {
        return $this->belongsTo(UserChatStatus::class, 'user_chat_status_id');
    }
    
}
