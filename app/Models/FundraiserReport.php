<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundraiserReport extends Model
{
    protected $fillable = [
        'fundraiser_post_id',
        'name',
        'email',
        'country_code',
        'phone',
        'message',
        'supporting_document',
    ];

    public function fundraiserPost(): BelongsTo
    {
        return $this->belongsTo(FundraiserPost::class);
    }
}
