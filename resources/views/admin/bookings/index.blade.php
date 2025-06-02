@extends('layouts.app')

@section('title', __('messages.room_bookings'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-6 px-4 sm:px-6 lg:px-8" 
     x-data="{ search: '{{ request('search') }}', showFilters: false }" 
     x-init="$watch('search', value => $refs.searchForm.submit())"
     dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto">

        {{-- Header with RTL support --}}
        <div class="mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                    {{ __('messages.room_bookings') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">{{ __('messages.manage_room_bookings') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button @click="showFilters = !showFilters" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white text-sm font-medium rounded-lg shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    {{ __('messages.filters') }}
                </button>
                <a href="{{ route('admin.bookings.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('messages.new_booking') }}
                </a>
            </div>
        </div>

        {{-- Filters Section --}}
        <div x-show="showFilters" x-transition class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md ring-1 ring-gray-200 dark:ring-gray-700">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.status') }}</label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">{{ __('messages.all_statuses') }}</option>
                        @foreach(\App\Enums\BookingStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ __('messages.' . $status->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.date_range') }}</label>
                    <div class="flex gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-2 focus:ring-blue-500 focus:border-blue-500">
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                        {{ __('messages.apply_filters') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Search Bar --}}
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md ring-1 ring-gray-200 dark:ring-gray-700">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="w-full" x-ref="searchForm">
                <div class="relative">
                    <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" x-model="search"
                           placeholder="{{ __('messages.search_by_guest_or_room') }}"
                           class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10 pl-3' : 'pl-10 pr-3' }} py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150" />
                </div>
            </form>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.total_bookings') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.confirmed') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['confirmed'] }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.tentative') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['tentative'] }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.cancelled') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['cancelled'] }}</p>
                    </div>
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Cards View --}}
        <div class="block md:hidden space-y-4 mb-6">
            @forelse($bookings as $booking)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $booking->unit->unit_number }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->unit->building->name ?? '-' }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($booking->status === \App\Enums\BookingStatus::Confirmed) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($booking->status === \App\Enums\BookingStatus::Cancelled) bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif(is_string($booking->status) && $booking->status === 'cancelled_due_to_rent') bg-blue-100 text-black-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                                @endif">
                                {{ __('messages.' . (is_string($booking->status) ? $booking->status : $booking->status->value)) }}
                            </span>
                        </div>
                        
                        <div class="mt-3 grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.start_date') }}</p>
                                <p class="text-sm font-medium">{{ $booking->start_date->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.end_date') }}</p>
                                <p class="text-sm font-medium">{{ $booking->end_date->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.booked_by') }}</p>
                                <p class="text-sm font-medium">
                                    @can('view booking owner')
                                        {{ $booking->user->name ?? '-' }}
                                    @else
                                        —
                                    @endcan
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                            <a href="{{ route('admin.bookings.show', $booking) }}" 
                               class="flex-1 text-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg">
                                {{ __('messages.details') }}
                            </a>
                            
                            @if($booking->status === \App\Enums\BookingStatus::Tentative && !$booking->deposit_paid)
                                <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" 
                                      onsubmit="return confirm('{{ __('messages.confirm_booking_prompt') }}')" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg">
                                        {{ __('messages.confirm') }}
                                    </button>
                                </form>
                            @endif
                            
                            @if(in_array($booking->status, [\App\Enums\BookingStatus::Tentative, \App\Enums\BookingStatus::Confirmed]) && 
                                (!$booking->auto_expire_at || now()->lt($booking->auto_expire_at)) &&
                                ($booking->user_id === auth()->id() || auth()->user()->can('cancel bookings')))
                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}"
                                      onsubmit="return confirm('{{ __('messages.confirm_cancel_booking') }}')" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg">
                                        {{ __('messages.cancel') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md text-center">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_bookings_found') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden md:block bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">#</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.unit_number') }}</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.building') }}</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.dates') }}</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.status') }}</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.booked_by') }}</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    <div class="font-medium">{{ $booking->unit->unit_number }}</div>
                                    <div class="text-xs text-gray-400">{{ __('messages.unit_type_' . $booking->unit->unit_type) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ $booking->unit->building->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    <div>{{ $booking->start_date->format('Y-m-d') }}</div>
                                    <div class="text-xs text-gray-400">{{ __('messages.to') }}</div>
                                    <div>{{ $booking->end_date->format('Y-m-d') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->status === \App\Enums\BookingStatus::Confirmed) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($booking->status === \App\Enums\BookingStatus::Cancelled) bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif(is_string($booking->status) && $booking->status === 'cancelled_due_to_rent') bg-blue-100 text-black-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200
                                        @endif">
                                        {{ __('messages.' . (is_string($booking->status) ? $booking->status : $booking->status->value)) }}
                                    </span>
                                    @if($booking->auto_expire_at)
                                        <div class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                            {{ __('messages.expires_at') }}: {{ $booking->auto_expire_at->format('Y-m-d H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    @can('view booking owner')
                                        <div>{{ $booking->user->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-400">{{ $booking->user->email ?? '' }}</div>
                                    @else
                                        —
                                    @endcan
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    <div class="flex {{ app()->getLocale() === 'ar' ? 'space-x-reverse space-x-2' : 'space-x-2' }}">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="p-2 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors"
                                           title="{{ __('messages.show_details') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        @if($booking->status === \App\Enums\BookingStatus::Tentative && !$booking->deposit_paid)
                                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" 
                                                  onsubmit="return confirm('{{ __('messages.confirm_booking_prompt') }}')">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-lg hover:bg-green-200 dark:hover:bg-green-800 transition-colors"
                                                        title="{{ __('messages.confirm_booking') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(in_array($booking->status, [\App\Enums\BookingStatus::Tentative, \App\Enums\BookingStatus::Confirmed]) && 
                                            (!$booking->auto_expire_at || now()->lt($booking->auto_expire_at)) &&
                                            ($booking->user_id === auth()->id() || auth()->user()->can('cancel bookings')))
                                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}"
                                                  onsubmit="return confirm('{{ __('messages.confirm_cancel_booking') }}')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="p-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition-colors"
                                                        title="{{ __('messages.cancel_booking') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.no_bookings_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('messages.showing') }} {{ $bookings->firstItem() }} - {{ $bookings->lastItem() }} {{ __('messages.of') }} {{ $bookings->total() }}
            </div>
            <div class="flex space-x-2">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection