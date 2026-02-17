<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = [
        'image_path',
        'caption',
        'category',
        'date',
        'created_by',
    ];

    // Accessor for title (alias for caption)
    public function getTitleAttribute(): ?string
    {
        return $this->caption;
    }

    protected $casts = [
        'date' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
