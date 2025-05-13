@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            {{-- صورة المستخدم --}}
            <img src="{{ asset($user->photo_url ?? 'storage/users/default-avatar.png') }}"
                 class="w-24 h-24 rounded-full object-cover border-2 shadow"
                 onerror="this.src='{{ asset('storage/users/default-avatar.png') }}'">

            <div class="flex-1">
                {{-- الاسم والإيميل --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $user->name }}</h2>
                <p class="text-gray-600 mb-1"><i class="fas fa-envelope text-gray-400 mr-1"></i> {{ $user->email }}</p>

                {{-- الحالة --}}
                <p class="text-sm mt-2">
                    <span class="inline-block px-3 py-1 rounded-full text-white text-xs
                        {{ $user->is_active ? 'bg-green-600' : 'bg-gray-500' }}">
                        {{ $user->is_active ? __('messages.active') : __('messages.inactive') }}
                    </span>
                </p>

                {{-- الرول --}}
                <p class="mt-4 text-sm">
                    <strong>{{ __('messages.roles') }}:</strong>
                    {{ $user->roles->pluck('name')->join(', ') ?: __('messages.no_role_assigned') }}
                </p>

               @php
    $permissions = $user->getAllPermissions()->pluck('name');
@endphp

@if($permissions->isNotEmpty())
    <div class="mt-4" x-data="{ expanded: false }">
        <strong class="text-sm">{{ __('messages.permissions') }}:</strong>

        <div class="flex flex-wrap gap-2 mt-2">
            <template x-for="(perm, index) in {{ $permissions }}" :key="index">
                <span
                    x-show="expanded || index < 6"
                    class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs"
                    x-text="perm"></span>
            </template>
        </div>

        @if($permissions->count() > 6)
            <button type="button"
                    @click="expanded = !expanded"
                    class="mt-3 text-blue-600 hover:underline text-sm">
                <span x-show="!expanded">{{ __('messages.show_all_permissions') }}</span>
                <span x-show="expanded">{{ __('messages.hide_permissions') }}</span>
            </button>
        @endif
    </div>
@endif

            </div>
        </div>

        {{-- زر العودة --}}
        <div class="mt-6 text-end">
            <a href="{{ route('admin.users.index') }}"
               class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                ← {{ __('messages.back') }}
            </a>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endpush
@endsection
