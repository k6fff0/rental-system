@extends('layouts.app')

@section('title', __('messages.new_booking'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-10">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 p-8 shadow-xl rounded-xl">

            <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">
                {{ __('messages.new_booking') }}
            </h1>

            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf

                {{-- الغرفة --}}
                <div class="mb-4">
                    <label for="unit_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('messages.unit_number') }}
                    </label>
                    <select name="unit_id" id="unit_id"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                        <option value="">{{ __('messages.choose_unit') }}</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                {{ $unit->unit_number }} - {{ $unit->building->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- تاريخ البداية --}}
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('messages.start_date') }}
                    </label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white dark:border-gray-600"
                        value="{{ old('start_date') }}">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- تاريخ النهاية --}}
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('messages.end_date') }}
                    </label>
                    <input type="date" name="end_date" id="end_date"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white dark:border-gray-600"
                        value="{{ old('end_date') }}">
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ملاحظات --}}
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('messages.notes') }}
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white dark:border-gray-600">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-xl">
                        {{ __('messages.confirm_booking') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
