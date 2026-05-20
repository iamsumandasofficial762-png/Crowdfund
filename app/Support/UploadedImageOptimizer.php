<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class UploadedImageOptimizer
{
    public static function optimizePublicImage(?string $path, int $maxWidth = 1600, int $quality = 78): void
    {
        if (! $path || ! extension_loaded('gd')) {
            return;
        }

        $fullPath = Storage::disk('public')->path($path);

        if (! is_file($fullPath)) {
            return;
        }

        [$width, $height, $type] = getimagesize($fullPath) ?: [0, 0, null];

        if ($width <= 0 || $height <= 0 || ! in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            return;
        }

        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
            IMAGETYPE_PNG => imagecreatefrompng($fullPath),
            IMAGETYPE_WEBP => imagecreatefromwebp($fullPath),
        };

        if (! $source) {
            return;
        }

        $targetWidth = min($width, $maxWidth);
        $targetHeight = (int) round($height * ($targetWidth / $width));
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            imagealphablending($target, false);
            imagesavealpha($target, true);
        }

        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        match ($type) {
            IMAGETYPE_JPEG => imagejpeg($target, $fullPath, $quality),
            IMAGETYPE_PNG => imagepng($target, $fullPath, 8),
            IMAGETYPE_WEBP => imagewebp($target, $fullPath, $quality),
        };

        imagedestroy($source);
        imagedestroy($target);
    }
}
