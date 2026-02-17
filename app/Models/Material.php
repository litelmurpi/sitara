<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $fillable = [
        'title',
        'content',
        'video_url',
        'date',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getYoutubeEmbedUrl(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        // Extract YouTube video ID
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\?\/]+)/', $this->video_url, $matches);

        if (!empty($matches[1])) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        return $this->video_url;
    }
}
