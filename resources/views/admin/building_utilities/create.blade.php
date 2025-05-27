@extends('layouts.app')

@section('title', __('messages.add_utility'))

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    {{-- العنوان --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.add_utility') }}</h1>
    </div>

    {{-- الفورم --}}
    <form action="{{ route('admin.building-utilities.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-6">
        @csrf

        {{-- المبنى --}}
        <div>
            <label for="building_id" class="block font-medium text-sm text-gray-700">
                {{ __('messages.building_name') }} <span class="text-red-500">*</span>
            </label>
            <select name="building_id" id="building_id" required
                    class="w-full mt-1 rounded-lg border-gray-300">
                <option value="">{{ __('messages.choose_building') }}</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- نوع المرفق --}}
        <div>
            <label for="type" class="block font-medium text-sm text-gray-700">
                {{ __('messages.utility_type') }} <span class="text-red-500">*</span>
            </label>
            <select name="type" id="type" required
                    class="w-full mt-1 rounded-lg border-gray-300">
                <option value="">{{ __('messages.choose_type') }}</option>
                <option value="electricity" {{ old('type') == 'electricity' ? 'selected' : '' }}>
                    {{ __('messages.electricity') }}
                </option>
                <option value="water" {{ old('type') == 'water' ? 'selected' : '' }}>
                    {{ __('messages.water') }}
                </option>
                <option value="internet" {{ old('type') == 'internet' ? 'selected' : '' }}>
                    {{ __('messages.internet') }}
                </option>
            </select>
        </div>

        {{-- الرقم / الكود --}}
        <div>
            <label for="value" class="block font-medium text-sm text-gray-700">
                {{ __('messages.utility_value') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" name="value" id="value" required
                   value="{{ old('value') }}"
                   class="w-full mt-1 rounded-lg border-gray-300">
        </div>

        {{-- اسم المالك --}}
        <div>
            <label for="owner_name" class="block font-medium text-sm text-gray-700">
                {{ __('messages.owner_name') }}
            </label>
            <input type="text" name="owner_name" id="owner_name"
                   value="{{ old('owner_name') }}"
                   class="w-full mt-1 rounded-lg border-gray-300">
        </div>

        {{-- رقم الهوية --}}
        <div>
            <label for="owner_id_number" class="block font-medium text-sm text-gray-700">
                {{ __('messages.owner_id') }}
            </label>
            <input type="text" name="owner_id_number" id="owner_id_number"
                   value="{{ old('owner_id_number') }}"
                   class="w-full mt-1 rounded-lg border-gray-300">
        </div>

        {{-- صورة الهوية --}}
        <div>
            <label for="owner_id_image" class="block font-medium text-sm text-gray-700">
                {{ __('messages.owner_id_image') }}
            </label>
            <input type="file" name="owner_id_image[]" id="owner_id_image" multiple class="w-full mt-1 border-gray-300 rounded-lg">
        </div>

        {{-- الملاحظات --}}
        <div>
            <label for="notes" class="block font-medium text-sm text-gray-700">
                {{ __('messages.notes') }}
            </label>
            <textarea name="notes" id="notes" rows="3"
                      class="w-full mt-1 rounded-lg border-gray-300">{{ old('notes') }}</textarea>
        </div>

        {{-- زر الحفظ --}}
        <div class="text-left">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                {{ __('messages.save') }}
            </button>
        </div>
    </form>
</div>
@endsection
