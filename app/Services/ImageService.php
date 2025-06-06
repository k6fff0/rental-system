<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ImageService
{
    public static function uploadAndOptimize(UploadedFile $file, string $folder = 'unit_images'): string
    {
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $relativePath = "$folder/$filename";

        // ✅ احفظ الصورة باستخدام Laravel Storage
        Storage::disk('public')->put($relativePath, file_get_contents($file));

        // ✅ اضغط الصورة فيزيائيًا
        $fullPath = public_path("storage/$relativePath");
        ImageOptimizer::optimize($fullPath);

        // ✅ رجع المسار المناسب للعرض
        return "storage/$relativePath";
    }
}
