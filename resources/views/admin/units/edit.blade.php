@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-4xl">
        {{-- زر العودة --}}
        <a href="{{ route('admin.units.index') }}"
            class="inline-flex items-center px-4 py-2 mb-6 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-all duration-200">
            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('messages.back_to_units') }}
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            {{-- 🏷️ العنوان --}}
            <div class="flex items-center mb-8">
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-xl mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ __('messages.edit_unit') }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.edit_unit_description') }}</p>
                </div>
            </div>

            {{-- 🛑 عرض الأخطاء --}}
            @if ($errors->any())
                <div class="mb-8 p-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-semibold text-red-800 dark:text-red-200">{{ __('messages.validation_errors') }}</h3>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ⚠️ تحذير بوجود عقد مرتبط بالغرفة --}}
            @if ($unit->status === 'occupied' && isset($activeContract))
                <div class="mb-8 p-5 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-amber-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="font-semibold text-amber-800 dark:text-amber-200">
                                {{ __('messages.unit_has_active_contract') }}
                            </p>
                            <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">
                                {{ __('messages.unit_linked_to_contract_number', ['number' => $activeContract->contract_number]) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- 📝 النموذج --}}
            <form method="POST" action="{{ route('admin.units.update', $unit->id) }}" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- معلومات أساسية --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('messages.basic_information') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- المبنى --}}
                        <div>
                            <label for="building_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.building') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="building_id" id="building_id"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm py-3 px-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}"
                                        {{ $building->id == old('building_id', $unit->building_id) ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- رقم الوحدة --}}
                        <div>
                            <label for="unit_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.unit_number') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="unit_number" id="unit_number"
                                value="{{ old('unit_number', $unit->unit_number) }}"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm py-3 px-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                required>
                        </div>

                        {{-- الدور --}}
                        <div>
                            <label for="floor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.floor') }}
                            </label>
                            <input type="number" name="floor" id="floor" value="{{ old('floor', $unit->floor) }}"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm py-3 px-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>

                        {{-- السعر --}}
                        <div>
                            <label for="rent_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.rent_price') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="rent_price" id="rent_price" step="0.01" required
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm py-3 px-4 pr-12 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    value="{{ old('rent_price', $unit->rent_price) }}">
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 dark:text-gray-400 text-sm">
                                    {{ __('messages.currency') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- تفاصيل الوحدة --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ __('messages.unit_details') }}
                    </h3>

                    {{-- نوع الوحدة --}}
                    <div class="mb-6">
                        <label for="unit_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.unit_type') }}
                        </label>
                        <select name="unit_type" id="unit_type"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm py-3 px-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            {{-- وحدات مفروشة --}}
                            <optgroup label="{{ __('messages.furnished_units') }}">
                                @php
                                    $furnished = [
                                        'furnished_studio',
                                        'furnished_room_lounge',
                                        'furnished_two_rooms_lounge',
                                        'furnished_apartment',
                                    ];
                                @endphp
                                @foreach ($furnished as $type)
                                    <option value="{{ $type }}"
                                        {{ old('unit_type', $unit->unit_type ?? '') === $type ? 'selected' : '' }}>
                                        {{ __('messages.unit_type_' . $type) }}
                                    </option>
                                @endforeach
                            </optgroup>
                            {{-- وحدات غير مفروشة --}}
                            <optgroup label="{{ __('messages.unfurnished_units') }}">
                                @php
                                    $unfurnished = ['studio', 'room_lounge', 'two_rooms_lounge', 'apartment'];
                                @endphp
                                @foreach ($unfurnished as $type)
                                    <option value="{{ $type }}"
                                        {{ old('unit_type', $unit->unit_type ?? '') === $type ? 'selected' : '' }}>
                                        {{ __('messages.unit_type_' . $type) }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                     {{-- ✅ الحالة بالألوان --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.status') }}
                        <span class="text-gray-400 text-xs block mt-1">{{ __('messages.status_hint') }}</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @php
                            $statuses = [
                                'available' => [
                                    'label' => 'status_available',
                                    'bg' => 'bg-green-200',
                                    'text' => 'text-green-800',
                                ],
                                'booked' => [
                                    'label' => 'status_booked',
                                    'bg' => 'bg-purple-200',
                                    'text' => 'text-purple-800',
                                ],
                                'cleaning' => [
                                    'label' => 'status_cleaning',
                                    'bg' => 'bg-indigo-200',
                                    'text' => 'text-indigo-800',
                                ],
                                'maintenance' => [
                                    'label' => 'status_maintenance',
                                    'bg' => 'bg-yellow-200',
                                    'text' => 'text-yellow-800',
                                ],
                            ];
                        @endphp

                        @foreach ($statuses as $value => $style)
                            <label
                                class="flex items-center px-4 py-2 rounded-md cursor-pointer {{ $style['bg'] }} {{ $style['text'] }} font-medium shadow-sm">
                                <input type="radio" name="status" value="{{ $value }}"
                                    class="form-radio focus:ring-0 text-current mr-2"
                                    {{ old('status', $unit->status) === $value ? 'checked' : '' }}>
                                {{ __('messages.' . $style['label']) }}
                            </label>
                        @endforeach
                    </div>
                </div>
                </div>

                {{-- ملاحظات --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('messages.additional_notes') }}
                    </h3>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.notes') }}
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm py-3 px-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                            placeholder="{{ __('messages.notes') }}">{{ old('notes', $unit->notes) }}</textarea>
                    </div>
                </div>

                {{-- الأزرار --}}
                <div class="flex justify-end space-x-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.units.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('messages.update_unit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection