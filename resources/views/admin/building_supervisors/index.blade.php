@extends('layouts.app')

@section('title', __('messages.building_supervisors'))

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6 px-3 sm:px-4 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-4 sm:mb-6">
            <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                        {{ __('messages.building_supervisors') }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-gray-600 leading-relaxed">
                        {{ __('messages.manage_building_supervisors') }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <div class="inline-flex items-center px-3 sm:px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <span class="text-xs sm:text-sm text-gray-600">
                            {{ __('messages.total_supervisors') }}:
                        </span>
                        <span class="{{ app()->getLocale() === 'ar' ? 'mr-2' : 'ml-2' }} text-xs sm:text-sm font-semibold text-gray-900">
                            {{ $users->total() ?? $users->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Cards View (sm and below) --}}
        <div class="block sm:hidden space-y-3">
            @forelse($users as $user)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">
                                {{ $user->name }}
                            </h3>
                            <p class="mt-1 text-xs text-gray-500 break-all">
                                {{ $user->email }}
                            </p>
                            @if($user->phone)
                                <p class="mt-1 text-xs text-gray-500 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ $user->phone }}
                                </p>
                            @else
                                <p class="mt-1 text-xs text-gray-400 italic">
                                    {{ __('messages.no_phone') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between space-x-3 rtl:space-x-reverse">
                            <a href="{{ route('admin.building-supervisors.show', $user->id) }}"
                               class="flex-1 text-center px-3 py-2 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150">
                                {{ __('messages.view_buildings') }}
                            </a>
                            <a href="{{ route('admin.building-supervisors.edit', $user->id) }}"
                               class="flex-1 text-center px-3 py-2 text-xs font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-md hover:bg-indigo-100 transition-colors duration-150">
                                {{ __('messages.edit') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
                    <div class="text-gray-400 mb-3">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">
                        {{ __('messages.no_supervisors_message') }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View (sm and above) --}}
        <div class="hidden sm:block bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 lg:px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.name') }}
                            </th>
                            <th scope="col" class="px-4 lg:px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                {{ __('messages.email') }}
                            </th>
                            <th scope="col" class="px-4 lg:px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.assigned_buildings') }}
                            </th>
                            <th scope="col" class="px-4 lg:px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-start">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 truncate">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $user->phone ?? __('messages.no_phone') }}
                                            </div>
                                            {{-- Show email on small tablets --}}
                                            <div class="md:hidden text-xs text-gray-500 mt-1 break-all">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-sm text-gray-600 break-all">
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.building-supervisors.show', $user->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="{{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }} -{{ app()->getLocale() === 'ar' ? 'ml' : 'mr' }}-0.5 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ __('messages.view_buildings') }}
                                    </a>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.building-supervisors.edit', $user->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="{{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }} -{{ app()->getLocale() === 'ar' ? 'ml' : 'mr' }}-0.5 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('messages.edit') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 lg:px-6 py-12">
                                    <div class="text-center">
                                        <div class="text-gray-400 mb-3">
                                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-500">
                                            {{ __('messages.no_supervisors_message') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-xs sm:text-sm text-gray-700 text-center sm:{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <span class="font-medium">{{ __('messages.showing') }}</span>
                            <span class="font-medium">{{ $users->firstItem() }}</span>
                            <span>{{ __('messages.to') }}</span>
                            <span class="font-medium">{{ $users->lastItem() }}</span>
                            <span>{{ __('messages.of') }}</span>
                            <span class="font-medium">{{ $users->total() }}</span>
                            <span>{{ __('messages.results') }}</span>
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $users->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Mobile Pagination --}}
        @if($users->hasPages())
            <div class="block sm:hidden mt-4">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                    <div class="text-center mb-3">
                        <span class="text-xs text-gray-600">
                            {{ __('messages.showing') }} {{ $users->firstItem() }} - {{ $users->lastItem() }} {{ __('messages.of') }} {{ $users->total() }}
                        </span>
                    </div>
                    <div class="flex justify-center">
                        {{ $users->links('pagination::simple-tailwind') }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<style>
/* تحسينات إضافية للاتجاه العربي */
[dir="rtl"] .truncate {
    text-align: right;
}

[dir="rtl"] .break-all {
    text-align: right;
    word-break: break-all;
}

/* تحسين مظهر الأزرار في الوضع العربي */
[dir="rtl"] .inline-flex svg {
    margin-left: 0.375rem;
    margin-right: -0.125rem;
}

[dir="ltr"] .inline-flex svg {
    margin-right: 0.375rem;
    margin-left: -0.125rem;
}

/* تحسين التباعد في البطاقات */
.space-x-3 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0.75rem * var(--tw-space-x-reverse));
    margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse)));
}

[dir="rtl"] .space-x-3 {
    --tw-space-x-reverse: 1;
}

/* تحسين مظهر الجدول على الشاشات الصغيرة */
@media (max-width: 640px) {
    .min-w-full {
        min-width: 100%;
    }
}

/* تحسين مظهر التصفح */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.25rem;
}

.pagination a,
.pagination span {
    padding: 0.5rem 0.75rem;
    text-decoration: none;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.15s ease-in-out;
}

.pagination a:hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
}

.pagination .active span {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}
</style>
@endsection