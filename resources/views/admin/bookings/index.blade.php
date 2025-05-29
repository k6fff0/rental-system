@extends('layouts.app')

@section('title', __('messages.room_bookings'))

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8" x-data="{ search: '{{ request('search') }}' }" x-init="$watch('search', value => $refs.searchForm.submit())">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">
                    {{ __('messages.room_bookings') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.manage_room_bookings') }}</p>
            </div>
            <a href="{{ route('admin.bookings.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('messages.new_booking') }}
            </a>
        </div>

        {{-- Smart Search --}}
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow flex items-center gap-4">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="w-full" x-ref="searchForm">
                <input type="text" name="search" x-model="search"
                       placeholder="بحث باسم الحاجز أو رقم الغرفة"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-start">#</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.unit_number') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.building') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.start_date') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.end_date') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.status') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.booked_by') }}</th>
                        <th class="px-4 py-3 text-end">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    @foreach($bookings as $booking)
                        <tr>
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $booking->unit->unit_number }}</td>
                            <td class="px-4 py-3">{{ $booking->unit->building->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $booking->start_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $booking->end_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($booking->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($booking->status === 'cancelled_due_to_rent') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @endif">
                                    {{ __('messages.' . $booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @can('view booking owner')
                                    {{ $booking->user->name ?? '-' }}
                                @else
                                    —
                                @endcan
                            </td>
                            <td class="px-4 py-3 text-end">
                                @if($booking->status === 'active' && ($booking->user_id === auth()->id() || auth()->user()->can('cancel bookings')))
                                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الحجز؟')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-lg">
                                            {{ __('messages.cancel_booking') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
