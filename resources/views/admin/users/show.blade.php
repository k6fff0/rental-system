@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        {{ __('messages.edit_user') }}: {{ $user->name }}
    </h1>

    <div class="bg-white rounded-lg shadow p-6 space-y-6">

        {{-- عرض المجموعات --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.roles') }}</h2>
            @if($user->roles->isEmpty())
                <p class="text-gray-500">{{ __('messages.no_role_assigned') }}</p>
            @else
                <ul class="list-disc pl-5 text-sm text-gray-800">
                    @foreach($user->roles as $role)
                        <li>{{ __('roles.' . $role->name) ?? $role->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- الصلاحيات اليدوية --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.direct_permissions') }}</h2>
            @if($user->permissions->isEmpty())
                <p class="text-gray-500">{{ __('messages.none') }}</p>
            @else
                <ul class="list-disc pl-5 text-sm text-gray-800">
                    @foreach($user->permissions as $permission)
                        <li>{{ __('permissions.' . $permission->name) ?? $permission->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- جميع الصلاحيات (بما فيها من المجموعات) --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.all_permissions') }}</h2>
            @php
                $allPermissions = $user->getAllPermissions();
            @endphp
            @if($allPermissions->isEmpty())
                <p class="text-gray-500">{{ __('messages.none') }}</p>
            @else
                <ul class="list-disc pl-5 text-sm text-gray-800">
                    @foreach($allPermissions as $permission)
                        <li>{{ __('permissions.' . $permission->name) ?? $permission->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- زر رجوع --}}
        <div class="pt-4">
            <a href="{{ route('admin.users.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                {{ __('messages.back') }}
            </a>
        </div>
    </div>

</div>
@endsection
