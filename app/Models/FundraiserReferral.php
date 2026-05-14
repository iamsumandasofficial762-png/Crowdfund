<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundraiserReferral extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'fundraiser_post_id',
        'name',
        'country_code',
        'phone',
        'reason',
        'estimated_cost',
        'preferred_language',
        'alternate_country_code',
        'alternate_phone',
        'status',
    ];

    public function fundraiserPost(): BelongsTo
    {
        return $this->belongsTo(FundraiserPost::class);
    }
}
