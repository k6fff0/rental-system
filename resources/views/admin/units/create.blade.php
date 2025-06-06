@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 max-w-3xl">
        <a href="{{ route('admin.units.index') }}"
            class="inline-flex items-center px-4 py-2 mb-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition">

            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>

            {{ __('messages.back_to_units') }}
        </a>

        <div class="bg-white rounded-lg shadow-md p-6">
            {{-- 📌 العنوان --}}
            <div class="flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.add_unit') }}</h1>
            </div>

            {{-- 🚨 عرض الأخطاء --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                    <h3 class="font-bold mb-2">{{ __('messages.validation_errors') }}</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 📋 النموذج --}}
            <form method="POST" action="{{ route('admin.units.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- المبنى --}}
                    <div>
                        <label for="building_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.building') }} <span class="text-red-500">*</span>
                        </label>
                        <select name="building_id" id="building_id"
                            class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" required>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}">{{ $building->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- رقم الوحدة --}}
                    <div>
                        <label for="unit_number" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.unit_number') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="unit_number" id="unit_number"
                            class="w-full border border-gray-300 rounded-xl shadow-sm py-2.5 px-4 transition duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="{{ __('messages.enter_unit_number') }}" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- الدور --}}
                    <div>
                        <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.floor') }}
                        </label>
                        <input type="number" name="floor" id="floor"
                            class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                    </div>

                    {{-- نوع الوحدة --}}
                    <div>
                        <label for="unit_type" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.unit_type') }}
                        </label>
                        <select name="unit_type" id="unit_type"
                            class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                            @php
                                use App\Enums\UnitType;
                                $types = UnitType::cases();
                            @endphp

                            @foreach ($types as $type)
                                <option value="{{ $type->value }}"
                                    {{ old('unit_type', $unit->unit_type ?? '') === $type->value ? 'selected' : '' }}>
                                    {{ __('messages.unit_type_' . $type->value) }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    {{-- السعر --}}
                    <div>
                        <label for="rent_price" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('messages.rent_price') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="rent_price" id="rent_price" step="0.01" required
                            class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"
                            value="{{ old('rent_price') }}">
                    </div>
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
                                    {{ old('status') === $value ? 'checked' : '' }}>
                                {{ __('messages.' . $style['label']) }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- الملاحظات --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.notes') }}
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">{{ old('notes') }}</textarea>
                </div>

                {{-- الأزرار --}}
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.units.index') }}"
                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
