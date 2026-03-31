<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type'
    ];

    public function scopeDepositChat($query)
    {
        $query->where('type', 'deposit_chat');
    }

    public function scopeWithdrawChat($query)
    {
        $query->where('type', 'withdraw_chat');
    }

    public function getUnreadMessagesAttribute()
    {
        return $this->messages()
            ->whereNot('user_id', auth()->id())
            ->unreadMessages()->count();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
