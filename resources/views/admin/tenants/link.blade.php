@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.link_tenant_to_user') }}</h1>

        {{-- بيانات المستأجر --}}
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <p><strong>{{ __('messages.full_name') }}:</strong> {{ $tenant->name }}</p>
            <p><strong>{{ __('messages.id_number') }}:</strong> {{ $tenant->id_number ?? '-' }}</p>
            <p><strong>{{ __('messages.phone') }}:</strong> {{ $tenant->phone ?? '-' }}</p>
        </div>

        {{-- ربط المستأجر بحساب مستخدم موجود --}}
        <form action="{{ route('admin.tenants.attach-user', $tenant->id) }}" method="POST"
            class="bg-white shadow rounded-lg p-6 mb-6">
            @csrf

            <h2 class="text-lg font-semibold mb-4">{{ __('messages.link_existing_user') }}</h2>

            @if ($users->isEmpty())
                <div class="mb-4 bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded">
                    {{ __('messages.no_available_users') }}
                </div>
            @else
                <div class="mb-4">
                    <label for="user_id"
                        class="block text-sm font-medium text-gray-700">{{ __('messages.select_user') }}</label>
                    <select name="user_id" id="user_id" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        <option value="">{{ __('messages.choose_user') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                        {{ __('messages.link_user') }}
                    </button>
                </div>
            @endif
        </form>

        {{-- إنشاء حساب جديد للمستأجر --}}
        <form action="{{ route('admin.tenants.create-user', $tenant->id) }}" method="POST"
            class="bg-white shadow rounded-lg p-6">
            @csrf

            <h2 class="text-lg font-semibold mb-4">{{ __('messages.create_new_account') }}</h2>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                    value="{{ old('email', $tenant->email ?? '') }}">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('messages.password') }}</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold">
                    {{ __('messages.create_and_link') }}
                </button>
            </div>
        </form>
    </div>
@endsection
