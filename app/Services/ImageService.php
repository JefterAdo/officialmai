<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;

class ImageService
{
    public function optimizeAndStore(UploadedFile $image, string $path, int $width = 1200): string
    {
        $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
        $fullPath = $path . '/' . $filename;

        $optimizedImage = Image::make($image)
            ->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 85);

        Storage::put("public/{$fullPath}", (string) $optimizedImage);

        return $fullPath;
    }

    public function generateThumbnail(UploadedFile $image, string $path, int $width = 300): string
    {
        $filename = 'thumb_' . uniqid() . '_' . time() . '.webp';
        $fullPath = $path . '/' . $filename;

        $thumbnail = Image::make($image)
            ->fit($width, $width)
            ->encode('webp', 80);

        Storage::put("public/{$fullPath}", (string) $thumbnail);

        return $fullPath;
    }

    public function deleteImage(string $path): bool
    {
        return Storage::delete("public/{$path}");
    }
} 