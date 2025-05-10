@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_tenant') }}</h1>

    <form action="{{ route('admin.tenants.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        {{-- الاسم --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.full_name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- الوحدة --}}
        <div class="mb-4">
            <label for="unit_id" class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
            <select name="unit_id" id="unit_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">{{ __('messages.select_unit') }}</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->unit_number }}
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- رقم الهوية --}}
        <div class="mb-4">
            <label for="id_number" class="block text-sm font-medium text-gray-700">{{ __('messages.id_number') }}</label>
            <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('id_number')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- رقم الجوال --}}
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('messages.phone') }}</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('phone')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ملاحظات --}}
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes') }}</textarea>
        </div>

        {{-- الأزرار --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.tenants.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.back') }}
            </a>
            <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.save') }}
            </button>
        </div>
    </form>
</div>
@endsection
