@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_role') }}</h1>

    <form method="POST" action="{{ route('admin.role_manager.update', $role->id) }}" class="bg-white shadow rounded-xl p-6">
        @csrf
        @method('PUT')

        {{-- 🏷️ اسم المجموعة --}}
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.role_name') }}</label>
            <input type="text" name="name" id="name" required
                   class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 px-4 py-2 text-sm"
                   value="{{ old('name', $role->name) }}">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ✅ صلاحيات المجموعة --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.select_permissions') }}</label>

            {{-- 🔘 زر تحديد الكل --}}
            <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" id="select-all" class="rounded text-blue-600" onclick="toggleAllPermissions()">
                <label for="select-all" class="text-sm text-gray-700">{{ __('messages.select_all') }}</label>
            </div>

            {{-- ✅ قائمة الصلاحيات --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($permissions as $permission)
                    @continue($permission->name === 'super-admin') {{-- 🛡️ إخفاء صلاحية super-admin --}}
                    <label class="inline-flex items-center text-sm text-gray-800">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200"
                               {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                        <span class="ml-2">{{ __('permissions.' . $permission->name) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- 🎯 الأزرار --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.role_manager.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-md text-sm font-medium shadow">
                {{ __('messages.back') }}
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-semibold shadow">
                {{ __('messages.update') }}
            </button>
        </div>
    </form>
</div>

{{-- ⚙️ سكريبت اختيار الكل --}}
<script>
    function toggleAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        const selectAllCheckbox = document.getElementById('select-all');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>
@endsection
