@extends('layouts.app')

@section('title', __('messages.building_supervisors'))

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6 px-3 sm:px-4 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto">

     {{-- Header with Search --}}
<div class="mb-4 sm:mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- العنوان والوصف -->
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ __('messages.building_supervisors') }}
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('messages.manage_building_supervisors') }}
            </p>
        </div>

        <!-- 🔍 مربع البحث داخل فورم -->
        <form method="GET" class="w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('messages.search') }}..." 
                    class="w-full {{ app()->getLocale() === 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                <div class="absolute inset-y-0 flex items-center pointer-events-none {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                          M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0
                          M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="{{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}">
                <p class="text-sm font-medium text-gray-500">{{ __('messages.total_supervisors') }}</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $users->total() }}</p>
            </div>
        </div>
    </div>
</div>

        {{-- Mobile Cards View --}}
        <div class="block sm:hidden space-y-4">
            @forelse($users as $user)
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                <div class="p-4 flex items-start space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full object-cover" 
                             src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}" 
                             alt="{{ $user->name }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-900 truncate">
                                {{ $user->name }}
                                @if(!$user->is_active)
                                    <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        {{ __('messages.inactive') }}
                                    </span>
                                @endif
                            </h3>
                            <div class="flex space-x-2 rtl:space-x-reverse">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->buildings_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->buildings_count }} {{ __('messages.buildings') }}
                                </span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">{{ $user->email }}</p>
                        @if($user->phone)
                        <p class="mt-1 text-sm text-gray-600">
                            <svg class="inline h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $user->phone }}
                        </p>
                        @endif
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 flex justify-between space-x-3 rtl:space-x-reverse">
                    <a href="{{ route('admin.building-supervisors.show', $user->id) }}" 
                       class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ __('messages.view') }}
                    </a>
                    <a href="{{ route('admin.building-supervisors.edit', $user->id) }}" 
                       class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('messages.edit') }}
                    </a>

                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow p-8 text-center border border-gray-200">
                <div class="mx-auto h-16 w-16 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('messages.no_supervisors') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_supervisors_message') }}</p>

            </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden sm:block bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.supervisor') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.contact') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.total_buildings') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}" 
                                             alt="{{ $user->name }}">
                                    </div>
                                    <div class="{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $user->phone ?? __('messages.no_phone') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ __('messages.active') }}
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ __('messages.inactive') }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->buildings_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->buildings_count }} 
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <a href="{{ route('admin.building-supervisors.show', $user->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.building-supervisors.edit', $user->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-400 mb-3">
                                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                
                                <p class="mt-1 text-sm text-gray-500">{{ __('messages.no_supervisors_message') }}</p>

                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                        <span>{{ __('messages.showing') }}</span>
                        <span class="font-medium">{{ $users->firstItem() }}</span>
                        <span>{{ __('messages.to') }}</span>
                        <span class="font-medium">{{ $users->lastItem() }}</span>
                        <span>{{ __('messages.of') }}</span>
                        <span class="font-medium">{{ $users->total() }}</span>
                        <span>{{ __('messages.results') }}</span>
                    </div>
                    <div>
                        {{ $users->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* تحسينات للعرض على الجوال */
    @media (max-width: 640px) {
        .rtl .flex.space-x-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 1;
            margin-right: calc(0.5rem * var(--tw-space-x-reverse));
            margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
        }
        
        .ltr .flex.space-x-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.5rem * var(--tw-space-x-reverse));
            margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
        }
    }
    
    /* تحسينات للعرض العربي */
    [dir="rtl"] .text-right {
        text-align: right;
    }
    
    [dir="rtl"] .text-left {
        text-align: left;
    }
    
    /* تحسينات للصور */
    .object-cover {
        object-fit: cover;
    }
    
    /* تحسينات للجدول */
    .divide-y > :not([hidden]) ~ :not([hidden]) {
        --tw-divide-y-reverse: 0;
        border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
        border-bottom-width: calc(1px * var(--tw-divide-y-reverse));
    }
</style>
@endsection