@extends('layouts.app')

@section('title', __('messages.view_utility'))

{{-- يمكن إضافة أنماط CSS مخصصة هنا إذا لزم الأمر --}}
@push('styles')
<style>
    [x-cloak] { display: none !important; }
    /* يمكنك إضافة أي أنماط إضافية هنا */
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
{{-- ✅ العنوان مع الأيقونة وزر الرجوع --}}
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

    {{-- 🔵 عنوان الصفحة مع الأيقونة --}}
    <div class="flex items-center">
        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S3.732 16.057 2.458 12z" />
</svg>

        </div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            {{ __('messages.view_utility') }}
        </h1>
    </div>

    {{-- 🔙 زر العودة --}}
    <a href="{{ route('admin.building-utilities.index') }}"
       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition">

        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>

        {{ __('messages.back_to_utilities') }}
    </a>

</div>

 
    @php
        // التأكد من أن owner_id_image هو نص JSON صالح قبل فك ترميزه
        $imageJson = is_string($buildingUtility->owner_id_image) ? $buildingUtility->owner_id_image : '[]';
        // توفير مصفوفة فارغة افتراضية إذا فشل فك الترميز أو كان null
        $imagesArray = json_decode($imageJson, true) ?? [];
        // تصفية أي قيم غير نصية أو فارغة من مصفوفة الصور وإعادة ترتيب الفهرس
        $images = array_values(array_filter((array)$imagesArray, fn($img) => is_string($img) && !empty(trim($img))));
    @endphp

    {{-- ✅ بطاقة تفاصيل المرفق --}}
    <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg space-y-6">

        {{-- ✅ قسم التفاصيل الأساسية (في شكل شبكة) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 text-sm">
            @php
                $details = [
                    'building_name' => $buildingUtility->building->name ?? null,
                    'utility_type' => __('messages.' . $buildingUtility->type), // الترجمة تتم هنا مباشرة إذا كان المفتاح موجود
                    'utility_value' => $buildingUtility->value,
                    'owner_name' => $buildingUtility->owner_name ?? null,
                    'owner_id_number' => $buildingUtility->owner_id_number ?? null, // تم تغيير المفتاح ليتوافق مع العرض
                ];
            @endphp

            @foreach ($details as $key => $value)
                @if($value !== null && $value !== '')
                <div class="flex flex-col sm:flex-row sm:items-start py-1">
                    <strong class="w-full sm:w-1/3 text-gray-700 dark:text-gray-300 font-semibold">{{ __('messages.' . $key) }}:</strong>
                    <span class="w-full sm:w-2/3 text-gray-900 dark:text-gray-100 mt-1 sm:mt-0">{{ $value }}</span>
                </div>
                @endif
            @endforeach
        </div>

        {{-- ✅ قسم صور هوية المالك (السلايدر) --}}
        @if (count($images) > 0)
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">{{ __('messages.owner_id_image') }}:</h3>
            <div x-data="{
                    images: {{ json_encode($images) }},
                    current: 0,
                    autoplayInterval: null,
                    get count() { return this.images.length },
                    next() { this.current = (this.current + 1) % this.count },
                    prev() { this.current = (this.current - 1 + this.count) % this.count },
                    goTo(index) { this.current = index },
                    startAutoplay() {
                        if (this.count > 1) {
                            this.autoplayInterval = setInterval(() => { this.next(); }, 5000);
                        }
                    },
                    stopAutoplay() {
                        clearInterval(this.autoplayInterval);
                        this.autoplayInterval = null;
                    }
                }"
                 x-init="startAutoplay()"
                 @mouseenter="stopAutoplay()"
                 @mouseleave="startAutoplay()"
                 class="w-full max-w-lg mx-auto" {{-- يمكن تعديل max-width حسب الحاجة --}}
                 aria-labelledby="owner-id-images-heading"
            >
                {{-- حاوية الصورة الرئيسية للسلايدر --}}
                <div class="relative aspect-[4/3] sm:aspect-[16/10] overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700">
                    <template x-for="(img, index) in images" :key="index">
                        <div
                            x-show="current === index"
                            x-cloak
                            class="absolute inset-0 flex items-center justify-center transition-opacity duration-700 ease-in-out"
                            :class="{ 'opacity-100': current === index, 'opacity-0': current !== index }"
                        >
                            {{-- رابط لفتح الصورة بالحجم الكامل في تبويب جديد --}}
                            <a :href="'/storage/' + img" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-full h-full">
                                <img :src="'/storage/' + img"
                                     class="max-w-full max-h-full object-contain rounded-md p-1" {{-- p-1 لإضافة هامش بسيط حول الصورة داخل الإطار --}}
                                     :alt="`{{ __('messages.owner_id_image') }} ${index + 1}`">
                            </a>
                        </div>
                    </template>

                    {{-- أزرار التنقل (السابق/التالي) --}}
                    <template x-if="count > 1">
                        <div class="absolute inset-0 flex justify-between items-center px-1 sm:px-2 z-10" role="navigation">
                            <button @click="prev()"
                                    aria-label="{{ __('messages.previous_image') }}"
                                    class="bg-white/70 hover:bg-white dark:bg-gray-800/70 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 hover:text-black dark:hover:text-white rounded-full p-2 shadow-md transition-colors duration-200">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ app()->getLocale() === 'ar' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button @click="next()"
                                    aria-label="{{ __('messages.next_image') }}"
                                    class="bg-white/70 hover:bg-white dark:bg-gray-800/70 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 hover:text-black dark:hover:text-white rounded-full p-2 shadow-md transition-colors duration-200">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ app()->getLocale() === 'ar' ? 'transform rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>

                {{-- نقاط المؤشر للانتقال السريع بين الصور --}}
                <template x-if="count > 1">
                    <div class="flex justify-center mt-4 space-x-2 rtl:space-x-reverse" role="tablist">
                        <template x-for="(img, index) in images" :key="'dot-' + index">
                            <button @click="goTo(index)"
                                 :aria-label="`{{ __('messages.go_to_image') }} ${index + 1}`"
                                 :aria-selected="current === index"
                                 role="tab"
                                 :class="{
                                    'bg-blue-600 dark:bg-blue-500 w-3 h-3': current === index,
                                    'bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 w-2.5 h-2.5': current !== index
                                 }"
                                 class="rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                            ></button>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        @elseif(isset($buildingUtility->owner_id_image) && !empty(json_decode($buildingUtility->owner_id_image, true)) && count($images) === 0)
        {{-- حالة وجود بيانات صور ولكنها غير صالحة أو فارغة بعد الفلترة --}}
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
             <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3" id="owner-id-images-heading">{{ __('messages.owner_id_image') }}:</h3>
             <p class="text-gray-600 dark:text-gray-400 bg-yellow-50 dark:bg-yellow-700 border border-yellow-200 dark:border-yellow-600 p-3 rounded-md">{{ __('messages.no_valid_images_found') }}</p>
        </div>
        @else
        {{-- حالة عدم وجود صور مرفقة أساسًا --}}
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3" id="owner-id-images-heading">{{ __('messages.owner_id_image') }}:</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ __('messages.no_images_uploaded') }}</p>
        </div>
        @endif

        {{-- ✅ قسم الملاحظات وتواريخ الإنشاء والتحديث --}}
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 space-y-4 text-sm">
             @if($buildingUtility->notes)
            <div>
                <strong class="text-gray-700 dark:text-gray-300 font-semibold">{{ __('messages.notes') }}:</strong>
                <p class="text-gray-800 dark:text-gray-100 whitespace-pre-wrap mt-1">{{ $buildingUtility->notes }}</p>
            </div>
            @endif
            <div>
                <strong class="text-gray-700 dark:text-gray-300 font-semibold">{{ __('messages.created_at') }}:</strong>
                <span class="text-gray-800 dark:text-gray-100">{{ $buildingUtility->created_at->format('Y-m-d H:i A') }}</span>
            </div>
            <div>
                <strong class="text-gray-700 dark:text-gray-300 font-semibold">{{ __('messages.updated_at') }}:</strong>
                <span class="text-gray-800 dark:text-gray-100">{{ $buildingUtility->updated_at->format('Y-m-d H:i A') }}</span>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
{{-- إذا لم يكن Alpine.js مُضمناً بشكل عام في layouts.app, قم بإلغاء التعليق عن السطر التالي --}}
{{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
@endpush