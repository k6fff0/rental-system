@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_role') }}</h1>

        <form action="{{ route('admin.roles.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.role_name') }}</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>



            <div class="flex justify-end">
                <a href="{{ route('admin.roles.index') }}"
                    class="mr-4 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
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
