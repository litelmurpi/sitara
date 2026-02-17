<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $fillable = [
        'santri_id',
        'type',
        'description',
        'points',
        'created_by',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($achievement) {
            $achievement->santri->recalculateTotalPoints();
        });

        static::updated(function ($achievement) {
            $achievement->santri->recalculateTotalPoints();
        });

        static::deleted(function ($achievement) {
            $achievement->santri->recalculateTotalPoints();
        });
    }
}
