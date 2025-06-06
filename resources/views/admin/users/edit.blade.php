@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden w-full md:w-auto">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5">
                        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">
                                    {{ __('messages.edit_user') }}
                                </h1>
                                <p class="text-blue-100 text-sm mt-1">
                                    {{ __('messages.edit_user_subtitle') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <!-- Back Button -->
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back') }}
                    </a>

                    @if ($user->is_active)
                        <form action="{{ route('admin.users.toggle-active', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                {{ __('messages.disable_account') }}
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.toggle-active', $user->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                {{ __('messages.enable_account') }}
                            </button>
                        </form>
                    @endif


                </div>
            </div>

            <!-- User Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('messages.user_information') }}
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- User Avatar -->
                        <div class="flex-shrink-0">
                            <div class="relative">
                                @if ($user->photo_url)
                                    <img class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-100"
                                        src="{{ $user->photo_url }}" alt="{{ $user->name }}"
                                        onerror="this.src='{{ asset('images/default-avatar.png') }}'; this.onerror=null;">
                                @else
                                    <div
                                        class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center ring-4 ring-gray-100">
                                        <span class="text-white font-semibold text-3xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif

                                <!-- ✅ Status Badge -->
                                <span
                                    class="absolute -bottom-2 -{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? __('messages.active') : __('messages.disabled') }}
                                </span>
                            </div>
                        </div>


                        <!-- User Details -->
                        <div class="flex-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500">{{ __('messages.name') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $user->name }}</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500">{{ __('messages.email') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $user->email }}</p>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500">{{ __('messages.phone') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">
                                        {{ $user->phone ?? __('messages.not_specified') }}</p>
                                </div>

                                <!-- Registration Date -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500">{{ __('messages.registration_date') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">
                                        {{ $user->created_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @csrf
                @method('PUT')

                <!-- Role Selection -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('messages.role_assignment') }}
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="role"
                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.select_role') }}</label>
                            <select name="role" id="role"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg shadow-sm">
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
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ __('messages.permissions') }}
                        </h3>
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                onclick="toggleAllPermissions()">
                            <label for="select-all"
                                class="ml-2 block text-sm text-gray-700">{{ __('messages.select_all') }}</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $rolePermissions = $user->roles->flatMap->permissions->pluck('id')->unique();
                        @endphp

                        @foreach ($permissions as $permission)
                            @continue($permission->name === 'super-admin')

                            @php
                                $isFromRole = $rolePermissions->contains($permission->id);
                                $isDirect = $user->permissions->contains($permission->id);
                            @endphp

                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                        value="{{ $permission->id }}"
                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                        {{ $isDirect ? 'checked' : '' }} {{ $isFromRole ? 'checked disabled' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="permission-{{ $permission->id }}" class="font-medium text-gray-700">
                                        {{ __('permissions.' . $permission->name) ?? $permission->name }}
                                    </label>
                                    @if ($isFromRole)
                                        <p class="text-xs text-gray-500">{{ __('messages.from_role') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        {{ __('messages.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Disable User Confirmation Modal -->
    <div id="disableModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ __('messages.disable_user') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ __('messages.disable_user_confirmation') }} "<span
                                        class="font-semibold">{{ $user->name }}</span>"?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            {{ __('messages.disable_account') }}
                        </button>
                    </form>
                    <button type="button" onclick="document.getElementById('disableModal').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAllPermissions() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]:not(:disabled)');
            const selectAll = document.getElementById('select-all');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        }

        function confirmDisable() {
            document.getElementById('disableModal').classList.remove('hidden');
        }
    </script>
@endsection
