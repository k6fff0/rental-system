@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    {{-- ✅ العنوان والفلاتر --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.users_list') }}</h1>

        <form method="GET" id="filterForm" class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
            {{-- فلتر الرول --}}
            <select name="role_id"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">{{ __('messages.filter_by_role') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>

            {{-- مربع البحث --}}
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_users') }}"
                   class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-full sm:w-64 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            {{-- زر الإضافة --}}
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md transition-colors duration-300 whitespace-nowrap">
                <i class="fas fa-plus mr-2"></i> {{ __('messages.add_user') }}
            </a>
        </form>
    </div>

    {{-- ✅ عرض المستخدمين --}}
    @if ($users->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
            <i class="fas fa-users-slash text-4xl mb-4 text-gray-300"></i>
            <p class="text-lg">{{ __('messages.no_users') }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($users as $user)
                @php
                    $permissions = $user->getAllPermissions()->pluck('name');
                @endphp

                <div class="bg-white p-6 rounded-lg shadow border hover:shadow-md transition duration-300 flex flex-col">
                    {{-- 🧑‍💼 معلومات المستخدم --}}
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="font-semibold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $user->is_active ? __('messages.active') : __('messages.inactive') }}
                        </span>
                    </div>

                    {{-- 🖼️ صورة المستخدم --}}
                    <div class="flex justify-center mb-3">
                        <img src="{{ asset($user->photo_url ?? 'storage/users/default-avatar.png') }}"
                             class="w-16 h-16 rounded-full object-cover border-2 border-white shadow"
                             onerror="this.src='{{ asset('storage/users/default-avatar.png') }}'">
                    </div>

                    {{-- 🎭 الأدوار --}}
                    <div class="mb-3 text-center">
                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                            {{ $user->roles->pluck('name')->join(', ') ?: __('messages.no_role_assigned') }}
                        </span>
                    </div>

                    {{-- 🛡️ الصلاحيات --}}
                    @if ($permissions->isNotEmpty())
                        <div class="border-t pt-3 mt-3">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('messages.permissions') }}</h3>
                            <div class="flex flex-wrap gap-1">
                                @foreach($permissions->take(4) as $permission)
                                    @php
                                    $slug = str_replace(' ', '_', strtolower($permission));
                                    $translated = trans('messages.permission_labels.' . $slug);
                                    @endphp
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                        {{ $translated !== 'messages.permission_labels.' . $slug ? $translated : $permission }}
                                    </span>
                                @endforeach
                                @if($permissions->count() > 4)
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                        +{{ $permissions->count() - 4 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- ⚙️ أزرار التحكم --}}
                    <div class="mt-4 pt-3 border-t flex justify-end gap-3">
                        <a href="{{ route('admin.users.show', $user->id) }}"
                           class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50 transition"
                           title="{{ __('messages.view_details') }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-50 transition"
                           title="{{ __('messages.edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition"
                                    title="{{ __('messages.delete') }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ✅ الباجينيشن --}}
        <div class="mt-8">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.querySelector('select[name="role_id"]');
        const searchInput = document.querySelector('input[name="search"]');
        const form = document.getElementById('filterForm');

        // 🌀 فلترة تلقائية عند تغيير الرول
        if (roleSelect) {
            roleSelect.addEventListener('change', () => {
                form.submit();
            });
        }

        // ⌛ انتظار توقف الكتابة في البحث ثم تنفيذ البحث
        let typingTimer;
        if (searchInput) {
            searchInput.addEventListener('keyup', () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    form.submit();
                }, 500);
            });

            searchInput.addEventListener('keydown', () => {
                clearTimeout(typingTimer);
            });
        }
    });
</script>
@endpush
@endsection
