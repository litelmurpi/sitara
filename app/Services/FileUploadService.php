<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file. Uses Cloudinary if configured, otherwise falls back to local storage.
     *
     * @param UploadedFile $file The file to upload
     * @param string $folder The folder/category (e.g., 'avatars', 'galleries', 'settings')
     * @return string The URL (Cloudinary) or relative path (local) of the uploaded file
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        if (self::isCloudinaryConfigured()) {
            return self::uploadToCloudinary($file, $folder);
        }

        return self::uploadToLocal($file, $folder);
    }

    /**
     * Delete a file. Detects whether it's a Cloudinary URL or local path.
     *
     * @param string|null $path The URL or relative path to delete
     */
    public static function delete(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        if (self::isCloudinaryUrl($path)) {
            self::deleteFromCloudinary($path);
        } else {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Check if a path is a Cloudinary URL.
     */
    public static function isCloudinaryUrl(?string $path): bool
    {
        return $path && str_contains($path, 'cloudinary.com');
    }

    /**
     * Check if Cloudinary is properly configured.
     */
    private static function isCloudinaryConfigured(): bool
    {
        return !empty(config('cloudinary.cloud_name'))
            && !empty(config('cloudinary.api_key'))
            && !empty(config('cloudinary.api_secret'));
    }

    /**
     * Upload to Cloudinary via REST API.
     */
    private static function uploadToCloudinary(UploadedFile $file, string $folder): string
    {
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');

        $timestamp = time();
        $params = [
            'folder' => 'sitara/' . $folder,
            'timestamp' => $timestamp,
        ];

        // Generate signature
        ksort($params);
        $signatureString = collect($params)
            ->map(fn($v, $k) => "{$k}={$v}")
            ->implode('&');
        $signature = sha1($signatureString . $apiSecret);

        try {
            $response = Http::timeout(30)
                ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                    'api_key' => $apiKey,
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                    'folder' => 'sitara/' . $folder,
                ]);

            if ($response->successful()) {
                return $response->json('secure_url');
            }

            // Log error and fall back to local
            \Log::warning('Cloudinary upload failed: ' . $response->body());
        } catch (\Exception $e) {
            \Log::warning('Cloudinary upload exception: ' . $e->getMessage());
        }

        // Fallback to local storage
        return self::uploadToLocal($file, $folder);
    }

    /**
     * Upload to local storage.
     */
    private static function uploadToLocal(UploadedFile $file, string $folder): string
    {
        return $file->store($folder, 'public');
    }

    /**
     * Delete from Cloudinary via REST API.
     */
    private static function deleteFromCloudinary(string $url): void
    {
        try {
            $cloudName = config('cloudinary.cloud_name');
            $apiKey = config('cloudinary.api_key');
            $apiSecret = config('cloudinary.api_secret');

            // Extract public_id from URL
            // URL format: https://res.cloudinary.com/{cloud}/image/upload/v123/sitara/avatars/filename.jpg
            $parts = parse_url($url);
            $pathParts = explode('/upload/', $parts['path'] ?? '');
            if (count($pathParts) < 2) return;

            $publicIdWithVersion = $pathParts[1];
            // Remove version prefix (v123456/)
            $publicId = preg_replace('/^v\d+\//', '', $publicIdWithVersion);
            // Remove file extension
            $publicId = preg_replace('/\.[^.]+$/', '', $publicId);

            $timestamp = time();
            $signatureString = "public_id={$publicId}&timestamp={$timestamp}" . $apiSecret;
            $signature = sha1($signatureString);

            Http::timeout(10)->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
                'public_id' => $publicId,
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]);
        } catch (\Exception $e) {
            \Log::warning('Cloudinary delete failed: ' . $e->getMessage());
        }
    }
}
