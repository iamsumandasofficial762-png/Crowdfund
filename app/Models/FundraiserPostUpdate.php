<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundraiserPostUpdate extends Model
{
    protected $fillable = [
        'fundraiser_post_id',
        'title',
        'update_text',
        'update_image',
        'is_published',
        'is_pinned',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    public function fundraiserPost(): BelongsTo
    {
        return $this->belongsTo(FundraiserPost::class);
    }
}
