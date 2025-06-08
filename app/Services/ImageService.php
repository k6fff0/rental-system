<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageService
{
    public static function uploadAndOptimize($file, $folder = 'uploads')
    {
        // ✅ 1. رفع الصورة في storage/app/public/{folder}
        $path = $file->store($folder, 'public');

        // ✅ 2. الحصول على المسار الكامل الفعلي (مش symlink)
        $fullPath = Storage::disk('public')->path($path);

        // ✅ 3. ضغط الصورة فعليًا
        OptimizerChainFactory::create()->optimize($fullPath);

        // ✅ 4. رجع المسار النسبي لحفظه في قاعدة البيانات
        return $path;
    }
}
