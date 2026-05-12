<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fundraiser extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'name',
        'email',
        'password',
        'country_code',
        'phone',
        'cause',
        'documents',
        'status',
        'approved_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'documents' => 'array',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    protected $hidden = [
        'password',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(FundraiserPost::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function getFullPhoneAttribute(): string
    {
        return trim($this->country_code.' '.$this->phone);
    }
}
