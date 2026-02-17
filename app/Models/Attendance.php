<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'santri_id',
        'date',
        'status',
        'check_in_time',
        'points_gained',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime:H:i:s',
        'points_gained' => 'integer',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($attendance) {
            $attendance->santri->recalculateTotalPoints();
        });

        static::updated(function ($attendance) {
            $attendance->santri->recalculateTotalPoints();
        });

        static::deleted(function ($attendance) {
            $attendance->santri->recalculateTotalPoints();
        });
    }
}
