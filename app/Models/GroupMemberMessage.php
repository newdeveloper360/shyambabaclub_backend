<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMemberMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'link',
        'image',
    ];
}
