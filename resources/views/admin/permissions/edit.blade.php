@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_permission') }}</h1>

        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST"
            class="bg-white shadow rounded-xl p-6">
            @csrf
            @method('PUT')

            {{-- اسم الصلاحية --}}
            <div class="mb-6">
                <label for="name"
                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.permission_name') }}</label>
                <input type="text" name="name" id="name" required
                    class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 px-4 py-2 text-sm"
                    value="{{ old('name', $permission->name) }}">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- أزرار التحكم --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.permissions.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-md text-sm font-medium shadow">
                    {{ __('messages.back') }}
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-semibold shadow">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
