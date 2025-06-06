@extends('layouts.app')

@section('title', __('messages.cleaning_dashboard'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.cleaning_dashboard') }}</h1>
                            <p class="text-gray-600 text-sm mt-1">{{ __('messages.manage_unit_cleaning') }}</p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $units->count() }}</div>
                            <div class="text-xs text-gray-500">{{ __('messages.units_in_cleaning') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Smart Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900">{{ __('messages.filters') }}</h3>
                </div>

                <form id="smart-filter-form" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Unit Number Filter -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.unit_number') }}</label>
                        <div class="relative">
                            <input type="text" id="unit_number" name="unit_number" value="{{ request('unit_number') }}"
                                placeholder="{{ __('messages.enter_unit_number') }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 transition-all duration-200"
                                autocomplete="off" />
                            <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>

                    <!-- Building Filter -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.building') }}</label>
                        <div class="relative">
                            <select name="building_id" id="building_id"
                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 appearance-none transition-all duration-200">
                                <option value="">{{ __('messages.all_buildings') }}</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}"
                                        {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </form>

                <!-- Clear Filters -->
                @if (request()->hasAny(['unit_number', 'building_id']))
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.cleaning.dashboard') }}"
                            class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('messages.clear_filters') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Units Grid -->
            @if ($units->isEmpty())
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.no_units_found') }}</h3>
                    <p class="text-gray-600">{{ __('messages.no_units_under_cleaning') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($units as $unit)
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                            <!-- Unit Header -->
                            <div class="p-6 pb-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                            {{ $unit->unit_number }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ __('messages.unit') }}
                                                #{{ $unit->unit_number }}</h3>
                                            <p class="text-xs text-gray-500">{{ $unit->building->name ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div
                                        class="flex items-center gap-1 px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">
                                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                                        {{ __('messages.in_cleaning') }}
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                                        <span>{{ __('messages.progress') }}</span>
                                        <span>{{ $unit->images_count }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                                            style="width: {{ min(($unit->images_count / 5) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload Section -->
                            <div class="px-6 pb-4">
                                <form action="{{ route('admin.units.images.upload', $unit) }}" method="POST"
                                    enctype="multipart/form-data" class="mb-4">
                                    @csrf
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition-colors group cursor-pointer"
                                        onclick="document.getElementById('images-{{ $unit->id }}').click()">
                                        <input type="file" id="images-{{ $unit->id }}" name="images[]" multiple
                                            accept="image/*" class="hidden" onchange="this.form.submit()">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2 group-hover:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <p class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors">
                                            {{ __('messages.click_to_upload_images') }}
                                        </p>
                                    </div>
                                </form>
                            </div>
                            <!-- صور الوحدة -->
                            @if ($unit->images->count())
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                        <h3
                                            class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ __('messages.unit_images') }}
                                        </h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="grid grid-cols-3 gap-2">
                                            @foreach ($unit->images as $image)
                                                <div class="relative group">
                                                    <a href="{{ asset('storage/' . $image->image_path) }}"
                                                        data-fancybox="gallery-{{ $unit->id }}" class="block">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                                            alt="Unit Image"
                                                            class="w-full aspect-square object-cover rounded-xl shadow-sm hover:shadow-md transition duration-300">
                                                    </a>

                                                    <!-- زر المسح -->
                                                    <form action="{{ route('admin.units.images.delete', $image) }}"
                                                        method="POST"
                                                        class="absolute top-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg transition-colors"
                                                            onclick="return confirm('{{ __('messages.confirm_delete_image') }}')">
                                                            ×
                                                        </button>
                                                    </form>

                                                    <!-- تأثير Hover مع أيقونة التكبير -->
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100"
                                                        style="pointer-events: none;">
                                                        <svg class="w-8 h-8 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Button -->
                            <div class="px-6 pb-6">
                                @if ($unit->images_count >= 5)
                                    <form action="{{ route('admin.units.mark.cleaned', $unit) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ __('messages.finish_cleaning') }}
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-center">
                                        <div class="flex items-center justify-center gap-2 text-amber-700 text-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" />
                                            </svg>
                                            {{ __('messages.need_more_images', ['count' => 5 - $unit->images_count]) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Fancybox.bind("[data-fancybox]", {
                    // إعدادات اختيارية هنا لو عايز
                });
            });
        </script>
    @endpush

    <!-- Smart Filter JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unitNumberInput = document.getElementById('unit_number');
            const buildingSelect = document.getElementById('building_id');
            const form = document.getElementById('smart-filter-form');

            let debounceTimer;

            // Smart filtering for unit number
            unitNumberInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (this.value.length >= 1 || this.value === '') {
                        form.submit();
                    }
                }, 500);
            });

            // Instant filtering for building selection
            buildingSelect.addEventListener('change', function() {
                form.submit();
            });

            // File upload animations
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const uploadZone = this.closest('.border-dashed');
                    if (uploadZone) {
                        uploadZone.classList.add('border-blue-500', 'bg-blue-50');
                        uploadZone.innerHTML = `
                    <div class="flex items-center justify-center">
                        <svg class="animate-spin w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="ml-2 text-blue-600">{{ __('messages.uploading') }}...</span>
                    </div>
                `;
                    }
                });
            });
        });
    </script>

    <style>
        /* RTL Improvements */
        [dir="rtl"] .grid {
            direction: ltr;
        }

        [dir="rtl"] .grid>* {
            direction: rtl;
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Custom scrollbar for better mobile experience */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Loading animation */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .grid-cols-1 {
                gap: 1rem;
            }

            .rounded-2xl {
                border-radius: 1rem;
            }

            .p-6 {
                padding: 1rem;
            }
        }
    </style>
@endsection
