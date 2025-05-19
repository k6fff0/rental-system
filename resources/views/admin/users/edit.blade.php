@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_user') }}</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        {{-- الاسم --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.name') }}</label>
            <input type="text" value="{{ $user->name }}" disabled
                   class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- الايميل --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
            <input type="email" value="{{ $user->email }}" disabled
                   class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm sm:text-sm">
        </div>

        {{-- اختيار المجموعة --}}
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('messages.select_role') }}</label>
            <select name="role" id="role"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">{{ __('messages.no_role') }}</option>
                @foreach ($roles as $role)
                    @continue($role->name === 'سوبر يوزر')
                    <option value="{{ $role->name }}"
                        {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- صلاحيات المستخدم --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.select_permissions') }}</label>
            <div class="flex items-center gap-2 mb-2">
                <input type="checkbox" id="select-all" class="rounded text-blue-600" onclick="toggleAllPermissions()">
                <label for="select-all">{{ __('messages.select_all') }}</label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $rolePermissions = $user->roles->flatMap->permissions->pluck('id')->unique();
                @endphp

                @foreach ($permissions as $permission)
                    @continue($permission->name === 'super-admin')

                    @php
                        $isFromRole = $rolePermissions->contains($permission->id);
                        $isDirect = $user->permissions->contains($permission->id);
                    @endphp

                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="permissions[]"
                            value="{{ $permission->id }}"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200"
                            {{ $isDirect ? 'checked' : '' }}
                            {{ $isFromRole ? 'checked disabled' : '' }}
                        >
                        <span class="ml-2">
                            {{ __('permissions.' . $permission->name) ?? $permission->name }}
                            @if ($isFromRole)
                                <span class="text-xs text-gray-400">({{ __('messages.from_role') }})</span>
                            @endif
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- زر التحديث --}}
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

<script>
    function toggleAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]:not(:disabled)');
        const selectAll = document.getElementById('select-all');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    }
</script>
@endsection
