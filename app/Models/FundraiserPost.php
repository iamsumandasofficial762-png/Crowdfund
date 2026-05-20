<?php

namespace App\Models;

use App\Support\PublicSiteCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundraiserPost extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_HOLD = 'hold';

    public const ACTION_APPROVE = 'approve';
    public const ACTION_HOLD = 'hold';
    public const ACTION_REJECT = 'reject';
    public const ACTION_DELETE = 'delete';

    protected $fillable = [
        'fundraiser_id',
        'title',
        'short_description',
        'full_description',
        'goal_amount',
        'raised_amount',
        'category',
        'beneficiary_name',
        'beneficiary_phone',
        'location',
        'main_image',
        'supporting_file',
        'status',
        'hold_reason',
        'rejected_reason',
        'held_at',
        'approved_at',
        'rejected_at',
        'admin_remarks',
    ];

    protected function casts(): array
    {
        return [
            'goal_amount' => 'decimal:2',
            'raised_amount' => 'decimal:2',
            'held_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => PublicSiteCache::forgetPublicContent());
        static::deleted(fn () => PublicSiteCache::forgetPublicContent());
    }

    public function fundraiser(): BelongsTo
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function paidDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', Donation::STATUS_PAID);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(FundraiserPostUpdate::class);
    }

    public function publishedUpdates(): HasMany
    {
        return $this->hasMany(FundraiserPostUpdate::class)->where('is_published', true);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_APPROVED)
            ->whereHas('fundraiser', fn (Builder $query) => $query->where('status', Fundraiser::STATUS_APPROVED));
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeHold(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_HOLD);
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_HOLD => 'Hold',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    public static function adminActionsForStatus(string $status): array
    {
        return match ($status) {
            self::STATUS_PENDING => [self::ACTION_APPROVE, self::ACTION_HOLD, self::ACTION_REJECT],
            self::STATUS_APPROVED => [self::ACTION_HOLD, self::ACTION_REJECT],
            self::STATUS_HOLD => [self::ACTION_APPROVE, self::ACTION_REJECT],
            self::STATUS_REJECTED => [self::ACTION_APPROVE, self::ACTION_DELETE],
            default => [],
        };
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? ucfirst((string) $this->status);
    }

    public function adminActions(): array
    {
        return self::adminActionsForStatus((string) $this->status);
    }

    public function canAdminAction(string $action): bool
    {
        return in_array($action, $this->adminActions(), true);
    }

    public function applyModerationStatus(string $status, ?string $reason = null): void
    {
        $data = match ($status) {
            self::STATUS_APPROVED => [
                'status' => self::STATUS_APPROVED,
                'approved_at' => now(),
                'held_at' => null,
                'rejected_at' => null,
                'hold_reason' => null,
                'rejected_reason' => null,
            ],
            self::STATUS_HOLD => [
                'status' => self::STATUS_HOLD,
                'hold_reason' => $reason,
                'held_at' => now(),
                'approved_at' => null,
                'rejected_at' => null,
                'rejected_reason' => null,
            ],
            self::STATUS_REJECTED => [
                'status' => self::STATUS_REJECTED,
                'rejected_reason' => $reason,
                'approved_at' => null,
                'held_at' => null,
                'rejected_at' => now(),
                'hold_reason' => null,
            ],
            default => [
                'status' => self::STATUS_PENDING,
                'approved_at' => null,
                'held_at' => null,
                'rejected_at' => null,
                'hold_reason' => null,
                'rejected_reason' => null,
            ],
        };

        $this->update($data);
    }
}
