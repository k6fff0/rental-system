@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🔧 العنوان --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.technicians_list') }}</h1>
    </div>

    {{-- 📋 جدول الفنيين --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.name') }}</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.email') }}</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.specialty') }}</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($technicians as $tech)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $tech->name }}</td>
                        <td class="px-6 py-4">{{ $tech->email }}</td>
                        <td class="px-6 py-4">
                            {{ $tech->technicianProfile->specialty ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $colors = [
                                    'available' => 'text-green-600',
                                    'busy' => 'text-yellow-600',
                                    'unavailable' => 'text-red-600',
                                ];
                            @endphp
                            <span class="font-semibold {{ $colors[$tech->technicianProfile->status ?? 'unavailable'] ?? '' }}">
                                {{ __('messages.status_' . ($tech->technicianProfile->status ?? 'unavailable')) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.technicians.show', $tech->id) }}"
                               class="text-blue-600 hover:underline text-xs font-medium">
                                {{ __('messages.show') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            {{ __('messages.no_technicians_found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
