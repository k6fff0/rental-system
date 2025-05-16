@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- 🏷️ العنوان --}}
        <div class="flex items-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.edit_unit') }}</h1>
        </div>

        {{-- 🛑 عرض الأخطاء --}}
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

        {{-- 📝 النموذج --}}
        <form method="POST" action="{{ route('admin.units.update', $unit->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- المبنى --}}
                <div>
                    <label for="building_id" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.building') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="building_id" id="building_id" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}" {{ $building->id == $unit->building_id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- رقم الغرفة --}}
                <div>
                    <label for="unit_number" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.unit_number') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="unit_number" id="unit_number" value="{{ old('unit_number', $unit->unit_number) }}" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- الدور --}}
                <div>
                    <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.floor') }}
                    </label>
                    <input type="number" name="floor" id="floor" value="{{ old('floor', $unit->floor) }}" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>

                {{-- نوع الوحدة --}}
                <div>
                    <label for="unit_type" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.unit_type') }}
                    </label>
                    <select name="unit_type" id="unit_type" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        @php
                            $types = ['studio', 'room_lounge', 'two_rooms_lounge', 'apartment'];
                        @endphp
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ old('unit_type', $unit->unit_type) == $type ? 'selected' : '' }}>
                                {{ __('messages.' . $type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- السعر --}}
                <div>
                    <label for="rent_price" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.rent_price') }}
                    </label>
                    <input type="number" name="rent_price" id="rent_price" step="0.01" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3" value="{{ old('rent_price', $unit->rent_price) }}">
                </div>
            </div>

            {{-- الحالة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('messages.status') }}
                    <span class="text-gray-400 text-xs block mt-1">{{ __('messages.status_hint') }}</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @php
                        $statuses = [
                            'available' => 'status_available',
                            'occupied' => 'status_occupied',
                            'booked' => 'status_booked',
                            'maintenance' => 'status_maintenance',
                            'cleaning' => 'status_cleaning',
                        ];
                    @endphp
                    @foreach ($statuses as $value => $label)
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="{{ $value }}"
                                class="h-4 w-4 text-{{ $value === 'available' ? 'green' : ($value === 'occupied' ? 'red' : ($value === 'booked' ? 'purple' : ($value === 'maintenance' ? 'yellow' : 'indigo'))) }}-500"
                                {{ old('status', $unit->status) === $value ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">{{ __('messages.' . $label) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- ملاحظات --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('messages.notes') }}
                </label>
                <textarea name="notes" id="notes" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">{{ old('notes', $unit->notes) }}</textarea>
            </div>

            {{-- الأزرار --}}
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.units.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('messages.update') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
