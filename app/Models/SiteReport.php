<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteReport extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_REVIEWED = 'reviewed';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'page_url',
        'subject',
        'message',
        'supporting_document',
        'status',
    ];
}
