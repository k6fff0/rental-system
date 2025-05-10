@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🔧 عنوان الصفحة --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_maintenance_request') }}</h1>

    {{-- 📋 فورم الإضافة --}}
    <form action="{{ route('admin.maintenance_requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        {{-- المبنى --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
            <select name="building_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">{{ __('messages.select_building') }}</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الوحدة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
            <select name="unit_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">{{ __('messages.select_unit') }}</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- نوع البلاغ --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.type') }}</label>
            <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">{{ __('messages.select_type') }}</option>
                @foreach(['كهرباء', 'سباكة', 'تكييف', 'صبغ', 'نجارة', 'أخرى'] as $type)
                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        {{-- وصف المشكلة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.description') }}</label>
            <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ old('description') }}</textarea>
        </div>

        {{-- الصورة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.image') }}</label>
            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-700" accept="image/*">
        </div>

        {{-- زر الحفظ --}}
        <div class="pt-4">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow text-sm font-semibold">
                {{ __('messages.save') }}
            </button>
        </div>
    </form>

</div>
@endsection
