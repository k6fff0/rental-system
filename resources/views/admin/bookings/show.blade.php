@extends('layouts.app')

@section('title', __('messages.booking_details'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-6 px-4 sm:px-6 lg:px-8"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto">
            {{-- Booking Card --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ __('messages.booking_details') }}
                            </h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-1">
                                #{{ $booking->id }} • {{ $booking->created_at->format('Y-m-d H:i') }}
                            </p>
                        </div>

                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white">
                            {{ __('messages.' . $booking->status->value) }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-6">
                    {{-- Main Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Unit Info --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('messages.unit_info') }}
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.unit_number') }}</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->unit->unit_number ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.building') }}</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->unit->building->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.unit_type') }}</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ __('messages.unit_type_' . $booking->unit->unit_type) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Guest Info --}}
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('messages.guest_info') }}
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.booked_by') }}</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->name ?? '-' }}</span>
                                </div>
                                @can('view booking owner')
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('messages.email') }}</span>
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->email ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">{{ __('messages.phone') }}</span>
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->phone ?? '-' }}</span>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                    {{-- Dates Section --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('messages.dates_info') }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="flex justify-between items-center bg-white dark:bg-gray-600 p-3 rounded-lg">
                                <div class="text-gray-600 dark:text-gray-400">{{ __('messages.period') }}</div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $booking->start_date->format('Y-m-d') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.to') }}</div>
                                    <div class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $booking->end_date->format('Y-m-d') }}</div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.created_at') }}</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                @if ($booking->tentative_at)
                                    <div class="flex justify-between">
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.tentative_at') }}</span>
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->tentative_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                @endif
                                @if ($booking->confirmed_at)
                                    <div class="flex justify-between">
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.confirmed_at') }}</span>
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->confirmed_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                @endif
                                @if ($booking->auto_expire_at)
                                    <div class="flex justify-between">
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.auto_expire_at') }}</span>
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->auto_expire_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                @endif
                                @if ($booking->cancelled_at)
                                    <div class="flex justify-between">
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.cancelled_at') }}</span>
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->cancelled_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Notes Section --}}
                    @if ($booking->notes)
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <h3 class="font-medium text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('messages.notes') }}
                            </h3>
                            <div class="bg-white dark:bg-gray-600 p-4 rounded-lg text-sm text-gray-800 dark:text-gray-200">
                                {{ $booking->notes }}
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.bookings.index') }}"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('messages.back_to_bookings') }}
                        </a>

                        @if ($booking->status === \App\Enums\BookingStatus::Tentative && !$booking->deposit_paid)
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('messages.confirm_booking') }}
                                </button>
                            </form>
                        @endif

                        @if (in_array($booking->status, [\App\Enums\BookingStatus::Tentative, \App\Enums\BookingStatus::Confirmed]) &&
                                (!$booking->auto_expire_at || now()->lt($booking->auto_expire_at)) &&
                                ($booking->user_id === auth()->id() || auth()->user()->can('cancel bookings')))
                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ __('messages.cancel_booking') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
