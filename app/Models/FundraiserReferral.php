<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundraiserReferral extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';
    public const SOURCE_REFER_US = 'refer_us';
    public const SOURCE_REQUEST_CALLBACK = 'request_call_back';

    protected $fillable = [
        'fundraiser_post_id',
        'source',
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

    public function sourceLabel(): string
    {
        return match ($this->source) {
            self::SOURCE_REQUEST_CALLBACK => 'Request a Call Back',
            default => 'Refer Us',
        };
    }
}
