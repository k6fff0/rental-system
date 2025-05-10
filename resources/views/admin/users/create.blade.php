@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_user') }}</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        {{-- الاسم --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.name') }}</label>
            <input type="text" name="name" id="name" required
                   value="{{ old('name') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring focus:ring-blue-200">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- البريد --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
            <input type="email" name="email" id="email" required
                   value="{{ old('email') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring focus:ring-blue-200">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- كلمة المرور --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('messages.password') }}</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring focus:ring-blue-200">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- تأكيد كلمة المرور --}}
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('messages.password_confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring focus:ring-blue-200">
        </div>

        {{-- اختيار المجموعة --}}
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('messages.select_role') }}</label>
            <select name="role" id="role"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">{{ __('messages.no_role') }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- صلاحيات إضافية --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.select_permissions') }}</label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($permissions as $permission)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200"
                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                        <span class="ml-2">{{ __('permissions.' . $permission->name) ?? $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- الأزرار --}}
        <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}"
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
