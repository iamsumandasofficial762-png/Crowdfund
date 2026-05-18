<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundraiserReport extends Model
{
    public const STATUS_UNDER_PROCESSING = 'under_processing';
    public const STATUS_SOLVED = 'solved';
    public const STATUS_DISMISSED = 'dismissed';

    protected $fillable = [
        'fundraiser_post_id',
        'name',
        'email',
        'country_code',
        'phone',
        'message',
        'supporting_document',
        'status',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_UNDER_PROCESSING => 'Under Processing',
            self::STATUS_SOLVED => 'Solved',
            self::STATUS_DISMISSED => 'Dismissed',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? self::statuses()[self::STATUS_UNDER_PROCESSING];
    }

    public function fundraiserPost(): BelongsTo
    {
        return $this->belongsTo(FundraiserPost::class);
    }
}
