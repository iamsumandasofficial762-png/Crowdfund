<?php

namespace App\Models;

use App\Support\PublicSiteCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    public const STATUS_PAID = 'paid';
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'fundraiser_post_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'main_amount',
        'tip_amount',
        'tip_percent',
        'message',
        'is_private',
        'payment_method',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'main_amount' => 'decimal:2',
            'tip_amount' => 'decimal:2',
            'tip_percent' => 'integer',
            'is_private' => 'boolean',
            'paid_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => PublicSiteCache::forgetPublicContent());
        static::deleted(fn () => PublicSiteCache::forgetPublicContent());
    }

    public function publicDonorName(): string
    {
        return $this->is_private ? 'Anonymous Donor' : ($this->donor_name ?: 'Anonymous Donor');
    }

    public function fundraiserPost(): BelongsTo
    {
        return $this->belongsTo(FundraiserPost::class);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PAID);
    }
}
