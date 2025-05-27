@extends('layouts.app')

@section('title', __('messages.view_utility'))

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ✅ العنوان --}}
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            {{ __('messages.view_utility') }}
        </h1>
        <a href="{{ route('admin.building-utilities.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← {{ __('messages.back_to_utilities') }}
        </a>
    </div>

    @php
        $images = json_decode($buildingUtility->owner_id_image, true) ?? [];
    @endphp

    {{-- ✅ تفاصيل المرفق --}}
    <div class="bg-white p-6 rounded-lg shadow space-y-4 text-sm text-gray-700">
        <div><strong>{{ __('messages.building_name') }}:</strong> {{ $buildingUtility->building->name ?? '-' }}</div>
        <div><strong>{{ __('messages.utility_type') }}:</strong> {{ __('messages.' . $buildingUtility->type) }}</div>
        <div><strong>{{ __('messages.utility_value') }}:</strong> {{ $buildingUtility->value }}</div>
        <div><strong>{{ __('messages.owner_name') }}:</strong> {{ $buildingUtility->owner_name ?? '-' }}</div>
        <div><strong>{{ __('messages.owner_id') }}:</strong> {{ $buildingUtility->owner_id_number ?? '-' }}</div>

        {{-- ✅ سلايدر الصور --}}
        <div x-data="{
                images: {{ json_encode($images) }},
                current: 0,
                get count() { return this.images.length },
                next() { this.current = (this.current + 1) % this.count },
                prev() { this.current = (this.current - 1 + this.count) % this.count }
            }"
            x-init="if (count > 1) setInterval(() => next(), 5000)"
        >
            <strong class="block mb-2">{{ __('messages.owner_id_image') }}:</strong>

            @if (count($images))
                <div class="relative w-full max-w-md mx-auto">
                    <template x-for="(img, index) in images" :key="index">
                        <div x-show="current === index" class="transition-all duration-500">
                            <img :src="'/storage/' + img" class="rounded-lg border w-full h-64 object-contain" alt="ID Image">
                        </div>
                    </template>

                    {{-- أزرار التنقل --}}
                    <div class="absolute inset-0 flex justify-between items-center px-2">
                        <button @click="prev()"
                                class="bg-white/80 text-gray-600 hover:text-black rounded-full p-1 shadow text-lg font-bold">
                            ‹
                        </button>
                        <button @click="next()"
                                class="bg-white/80 text-gray-600 hover:text-black rounded-full p-1 shadow text-lg font-bold">
                            ›
                        </button>
                    </div>

                    {{-- نقاط المؤشر --}}
                    <div class="flex justify-center mt-2 space-x-1 rtl:space-x-reverse">
                        <template x-for="(img, index) in images" :key="'dot-' + index">
                            <div :class="{
                                'bg-blue-600': current === index,
                                'bg-gray-300': current !== index
                            }"
                            class="h-2 w-2 rounded-full transition-all"></div>
                        </template>
                    </div>
                </div>
            @else
                <p class="text-gray-500">{{ __('messages.no_images') }}</p>
            @endif
        </div>

        <div><strong>{{ __('messages.notes') }}:</strong> {{ $buildingUtility->notes ?? '-' }}</div>
        <div><strong>{{ __('messages.created_at') }}:</strong> {{ $buildingUtility->created_at->format('Y-m-d H:i') }}</div>
        <div><strong>{{ __('messages.updated_at') }}:</strong> {{ $buildingUtility->updated_at->format('Y-m-d H:i') }}</div>
    </div>
</div>
@endsection
