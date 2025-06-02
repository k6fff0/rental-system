@extends('layouts.app')

@section('title', __('messages.assigned_buildings'))

@section('content')
<div class="min-h-screen bg-gray-50 py-4 sm:py-6 px-3 sm:px-4 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto">
        
        {{-- Page Header --}}
        <div class="mb-4 sm:mb-6">
            <div class="flex flex-col space-y-4 lg:space-y-0 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse mb-2">
                        <a href="{{ route('admin.building-supervisors.index') }}" 
                           class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                                {{ __('messages.assigned_buildings_for') }}: {{ $user->name }}
                            </h1>
                        </div>
                    </div>
                    <div class="{{ app()->getLocale() === 'ar' ? 'mr-11' : 'ml-11' }}">
                        <p class="text-xs sm:text-sm text-gray-600">
                            {{ __('messages.total_buildings') }}: <span class="font-semibold">{{ $buildings->total() ?? $buildings->count() }}</span>
                        </p>
                    </div>
                </div>
                
                {{-- User Info Cards --}}
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 flex-shrink-0">
                    <div class="inline-flex items-center px-3 py-2 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg text-xs sm:text-sm font-medium">
                        <svg class="{{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        <span class="truncate max-w-32 sm:max-w-none">{{ $user->email }}</span>
                    </div>
                    @if($user->phone)
                        <div class="inline-flex items-center px-3 py-2 bg-green-50 border border-green-200 text-green-800 rounded-lg text-xs sm:text-sm font-medium">
                            <svg class="{{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $user->phone }}
                        </div>
                    @else
                        <div class="inline-flex items-center px-3 py-2 bg-gray-50 border border-gray-200 text-gray-500 rounded-lg text-xs sm:text-sm font-medium">
                            <svg class="{{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 21L21 18m-7-7l-1-1" />
                            </svg>
                            {{ __('messages.no_phone') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Mobile Cards View (sm and below) --}}
        <div class="block lg:hidden space-y-3">
            @forelse($buildings as $building)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 hover:shadow-md transition-shadow duration-150">
                    <div class="flex items-start space-x-3 rtl:space-x-reverse">
                        <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 truncate mb-1">
                                {{ $building->name }}
                            </h3>
                            
                            {{-- Address --}}
                            @if($building->address)
                                <div class="flex items-start space-x-2 rtl:space-x-reverse mb-2">
                                    <svg class="h-4 w-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        {{ $building->address }}
                                    </p>
                                </div>
                            @endif

                           @if ($building->location_url)
    <div class="flex items-start space-x-2 rtl:space-x-reverse mb-2">
        <svg class="h-4 w-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 12l4.243-4.243a6 6 0 00-8.486-8.486L4.929 3.515a6 6 0 108.486 8.486l4.242-4.242z" />
        </svg>
        <a href="{{ $building->location_url }}" target="_blank" class="text-xs text-blue-600 underline hover:text-blue-800">
            {{ __('messages.view_location_on_map') }}
        </a>
    </div>
@endif


                            {{-- Assignment Date --}}
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">
                                        {{ __('messages.assigned_since') }}:
                                    </span>
                                </div>
                                <span class="text-xs font-medium text-gray-700">
                                    {{ optional($building->pivot->created_at)->format('Y-m-d') ?? __('messages.not_available') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 mb-2">
                            {{ __('messages.no_buildings_assigned') }}
                        </h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto leading-relaxed">
                            {{ __('messages.no_buildings_message') }}
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View (lg and above) --}}
        <div class="hidden lg:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.building_name') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.address') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.location') }}
                            </th>
                            <th scope="col" class="px-6 py-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.assigned_since') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($buildings as $building)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }} shadow-sm">
                                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 truncate">
                                                {{ $building->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $building->address }}">
                                        {{ $building->address ?? __('messages.no_address') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
								   @if($building->location_url)
    <a href="{{ $building->location_url }}" target="_blank" class="text-blue-600 underline hover:text-blue-800 text-sm">
        {{ __('messages.view_location_on_map') }}
    </a>
@else
    <span class="text-gray-400 text-sm">{{ __('messages.no_location') }}</span>
@endif

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="{{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-500">
                                            {{ optional($building->pivot->created_at)->format('Y-m-d') ?? __('messages.not_available') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12">
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-medium text-gray-900 mb-2">
                                            {{ __('messages.no_buildings_assigned') }}
                                        </h3>
                                        <p class="text-sm text-gray-500 max-w-sm mx-auto">
                                            {{ __('messages.no_buildings_message') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Desktop Pagination --}}
            @if($buildings->hasPages())
                <div class="bg-white px-6 py-3 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="text-xs sm:text-sm text-gray-700 text-center sm:{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <span>{{ __('messages.showing') }}</span>
                            <span class="font-medium">{{ $buildings->firstItem() }}</span>
                            <span>{{ __('messages.to') }}</span>
                            <span class="font-medium">{{ $buildings->lastItem() }}</span>
                            <span>{{ __('messages.of') }}</span>
                            <span class="font-medium">{{ $buildings->total() }}</span>
                            <span>{{ __('messages.results') }}</span>
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $buildings->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Mobile Pagination --}}
        @if($buildings->hasPages())
            <div class="block lg:hidden mt-4">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                    <div class="text-center mb-3">
                        <span class="text-xs text-gray-600">
                            {{ __('messages.showing') }} {{ $buildings->firstItem() }} - {{ $buildings->lastItem() }} {{ __('messages.of') }} {{ $buildings->total() }}
                        </span>
                    </div>
                    <div class="flex justify-center">
                        {{ $buildings->links('pagination::simple-tailwind') }}
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

/* تحسين مظهر الأيقونات في الوضع العربي */
[dir="rtl"] .flex svg:first-child {
    margin-left: 0.5rem;
    margin-right: 0;
}

[dir="ltr"] .flex svg:first-child {
    margin-right: 0.5rem;
    margin-left: 0;
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

.space-x-2 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-x-reverse: 0;
    margin-right: calc(0.5rem * var(--tw-space-x-reverse));
    margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
}

[dir="rtl"] .space-x-2 {
    --tw-space-x-reverse: 1;
}

/* تحسين مظهر التدرجات */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}

/* تحسين مظهر الجدول على الشاشات الصغيرة */
@media (max-width: 1024px) {
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

/* تحسين مظهر البطاقات عند التمرير */
.hover\:shadow-md:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* تحسين مظهر زر الرجوع */
.focus\:ring-2:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.focus\:ring-offset-2:focus {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(59, 130, 246, 0.5);
}
</style>
@endsection