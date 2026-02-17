<?php

if (!function_exists('santri_image')) {
    /**
     * Get the display URL for a stored image path.
     * Handles both Cloudinary URLs and local storage paths.
     *
     * @param string|null $path The stored path or URL
     * @param string $placeholder Default placeholder type ('avatar', 'image')
     * @return string The full URL to display
     */
    function santri_image(?string $path, string $placeholder = 'avatar'): string
    {
        if (empty($path)) {
            return match ($placeholder) {
                'avatar' => 'https://ui-avatars.com/api/?name=S&background=059669&color=fff&size=200',
                default => 'https://placehold.co/400x300/e2e8f0/94a3b8?text=No+Image',
            };
        }

        // Already a full URL (Cloudinary or external)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Local storage path
        return asset('storage/' . $path);
    }
}
