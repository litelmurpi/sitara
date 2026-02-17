<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Santri extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'parent_name',
        'parent_phone',
        'address',
        'birth_date',
        'qr_token',
        'parent_access_token',
        'total_points',
        'avatar',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'total_points' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($santri) {
            if (empty($santri->qr_token)) {
                $santri->qr_token = Str::uuid()->toString();
            }
            if (empty($santri->parent_access_token)) {
                $santri->parent_access_token = Str::uuid()->toString();
            }
        });
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * Check if santri has attended 7 consecutive days and award bonus.
     * Returns true if bonus was awarded.
     */
    public function checkWeeklyBonus(): bool
    {
        $today = now()->startOfDay();
        $consecutiveDays = 0;

        // Check last 7 days (including today)
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->subDays($i);
            $hasAttendance = $this->attendances()
                ->whereDate('date', $date)
                ->where('status', 'hadir')
                ->exists();

            if ($hasAttendance) {
                $consecutiveDays++;
            } else {
                break; // Streak broken
            }
        }

        // If 7 consecutive days, create bonus achievement
        if ($consecutiveDays >= 7) {
            // Check if bonus already given this week
            $weekStart = $today->copy()->startOfWeek();
            $existingBonus = $this->achievements()
                ->where('type', 'lainnya')
                ->where('description', 'like', '%Bonus Mingguan%')
                ->where('created_at', '>=', $weekStart)
                ->exists();

            if (!$existingBonus) {
                $this->achievements()->create([
                    'type' => 'lainnya',
                    'description' => 'Bonus Mingguan - Hadir 7 hari berturut-turut! 🎉',
                    'points' => 25,
                    'created_by' => auth()->id() ?? 1,
                ]);
                return true;
            }
        }

        return false;
    }

    public function recalculateTotalPoints(): void
    {
        $attendancePoints = $this->attendances()->sum('points_gained');
        $achievementPoints = $this->achievements()->sum('points');

        $this->update([
            'total_points' => $attendancePoints + $achievementPoints
        ]);
    }
}
