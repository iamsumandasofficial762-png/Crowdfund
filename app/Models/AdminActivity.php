<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AdminActivity extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'is_read',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('admin.activity_bell.summary'));
        static::deleted(fn () => Cache::forget('admin.activity_bell.summary'));
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }
}
