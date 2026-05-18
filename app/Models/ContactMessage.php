<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'request_type',
        'estimated_cost',
        'preferred_language',
        'reason',
        'description',
        'alternate_phone',
        'message',
    ];
}
