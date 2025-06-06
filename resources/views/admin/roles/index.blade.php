@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto">

            {{-- العنوان وزر الإضافة --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('messages.roles_list') }}</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ __('messages.manage_roles_description') }}</p>
                </div>
                <a href="{{ route('admin.roles.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('messages.add_role') }}
                </a>
            </div>

            {{-- بطاقات الأدوار --}}
            @if ($roles->isEmpty())
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('messages.no_roles') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_roles_description') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.roles.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('messages.add_first_role') }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($roles as $role)
                        <div
                            class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            {{-- رأس البطاقة --}}
                            <div class="px-4 py-5 sm:px-6 bg-white border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $role->name }}</h3>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $role->users_count }} {{ __('messages.users') }}
                                    </span>
                                </div>
                            </div>

                            {{-- محتوى البطاقة --}}
                            <div class="px-4 py-5 sm:p-6">
                                {{-- قائمة الصلاحيات --}}
                                <div class="mb-4">
                                    <button type="button"
                                        class="w-full flex justify-between items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-md transition-colors duration-150"
                                        onclick="toggleDropdown('dropdown-{{ $role->id }}')">
                                        <span>{{ __('messages.view_permissions') }}</span>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                                            id="arrow-{{ $role->id }}" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $role->id }}"
                                        class="hidden mt-2 space-y-2 max-h-60 overflow-y-auto">
                                        @forelse ($role->permissions as $perm)
                                            <div class="flex items-start px-3 py-2 bg-gray-50 rounded">
                                                <svg class="flex-shrink-0 h-5 w-5 text-green-500 mt-0.5"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span
                                                    class="ml-2 text-sm text-gray-700">{{ __('permissions.' . $perm->name) ?? $perm->name }}</span>
                                            </div>
                                        @empty
                                            <div class="px-3 py-2 text-sm text-gray-500 italic bg-gray-50 rounded">
                                                {{ __('messages.no_permissions') }}
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- أزرار الإجراءات --}}
                                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('messages.edit') }}
                                    </a>
                                    @if (!$role->is_default)
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                onclick="return confirm('{{ __('messages.confirm_delete_role') }}')">
                                                <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                {{ __('messages.delete') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- الترقيم --}}
            @if ($roles->hasPages())
                <div class="mt-8">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const arrowId = id.replace('dropdown', 'arrow');
            const arrow = document.getElementById(arrowId);

            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>

    <style>
        /* تحسينات للعرض العربي */
        [dir="rtl"] .rotate-180 {
            transform: rotate(180deg);
        }

        /* تحسينات للعرض على الجوال */
        @media (max-width: 640px) {
            .max-w-7xl {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* تحسينات للقوائم المنسدلة */
        .max-h-60 {
            max-height: 15rem;
        }

        /* تحسينات للظلال */
        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection
