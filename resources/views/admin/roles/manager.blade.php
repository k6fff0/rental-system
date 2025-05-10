@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.roles') }}</h1>

    {{-- ✅ نموذج إضافة مجموعة جديدة --}}
    <form method="POST" action="{{ route('admin.role_manager.store') }}" class="bg-white shadow p-6 rounded-lg mb-6">
        @csrf
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
            <input type="text" name="name" required
                placeholder="{{ __('messages.enter_role_name') }}"
                class="flex-1 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 text-sm px-4 py-2">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-semibold shadow">
                {{ __('messages.add') }}
            </button>
        </div>
        @error('name')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </form>

    {{-- ✅ عرض المجموعات --}}
    @if ($roles->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_roles_found') }}
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($roles as $role)
                <div class="bg-white p-6 shadow rounded-xl border border-gray-200 flex flex-col justify-between relative group">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">
                        {{ __('roles.' . $role->name) ?? $role->name }}
                    </h2>

                    {{-- قائمة منسدلة للصلاحيات --}}
                    <div class="relative mb-4">
                        <button type="button"
                            class="w-full flex justify-between items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 text-sm rounded shadow"
                            onclick="toggleDropdown('dropdown-{{ $role->id }}')">
                            {{ __('messages.view_permissions') }}
                            <svg class="w-4 h-4 transform transition-transform duration-200 group-hover:rotate-180"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5"/>
                            </svg>
                        </button>
                        <div id="dropdown-{{ $role->id }}"
                             class="hidden mt-2 bg-white border border-gray-200 rounded shadow p-3 text-sm max-h-40 overflow-auto z-10">
                            @forelse ($role->permissions as $perm)
                                <div class="text-gray-600">{{ __('permissions.' . $perm->name) ?? $perm->name }}</div>
                            @empty
                                <div class="text-gray-400 italic">{{ __('messages.no_permissions') }}</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- الأزرار --}}
                    <div class="flex justify-between items-center mt-auto pt-2 border-t border-gray-100">
                        <a href="{{ route('admin.role_manager.edit', $role->id) }}"
                            class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            {{ __('messages.edit') }}
                        </a>
                        <form action="{{ route('admin.role_manager.destroy', $role->id) }}" method="POST"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm font-medium text-red-600 hover:text-red-800">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- سكريبت لتبديل القوائم المنسدلة --}}
<script>
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
    }
</script>
@endsection
