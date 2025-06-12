@extends('layouts.app')

@section('title', __('vehicles.page_title'))

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

            <!-- Enhanced Header Section -->
            <div class="mb-8">
                <div
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/30 p-6 lg:p-8">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                        <!-- Title Section -->
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-3 rounded-2xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"
     xmlns="http://www.w3.org/2000/svg">
  <path d="M3 13.5V10l1.5-4.5A2 2 0 016.4 4h7.2a2 2 0 011.9 1.5L17 10v3.5a1.5 1.5 0 01-1.5 1.5H15a1.5 1.5 0 01-1.5-1.5V13h-7v.5A1.5 1.5 0 015 15H4.5A1.5 1.5 0 013 13.5zM6 12a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
</svg>


                            </div>
                            <div>
                                <h1
                                    class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                                    {{ __('vehicles.page_title') }}
                                </h1>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">{{ __('vehicles.manage_your_fleet') }}
                                </p>
                            </div>
                        </div>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                            <a href="{{ route('vehicles.reports') }}"
                                class="group relative overflow-hidden bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 dark:from-slate-600 dark:to-slate-700 dark:hover:from-slate-700 dark:hover:to-slate-800 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                </div>
                                <div class="relative flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span>{{ __('vehicles.reports') }}</span>
                                </div>
                            </a>

                            <a href="{{ route('vehicles.create') }}"
                                class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                </div>
                                <div class="relative flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span>{{ __('vehicles.add_vehicle') }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Success Message -->
            @if (session('success'))
                <div class="mb-8 animate-slide-down">
                    <div
                        class="bg-gradient-to-r from-emerald-500 to-green-500 text-white p-4 rounded-2xl shadow-xl border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <div class="bg-white/20 p-2 rounded-full">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Desktop Table View -->
            <div class="hidden xl:block mb-8">
                <div
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700/30 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead
                                class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
                                <tr>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span>{{ __('vehicles.plate_number') }}</span>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span>{{ __('vehicles.brand') }}</span>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>{{ __('vehicles.driver') }}</span>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>{{ __('vehicles.license_expiry_date') }}</span>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <span>{{ __('vehicles.insurance_expiry_date') }}</span>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            <span>{{ __('vehicles.status') }}</span>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-5 text-start text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                            <span>{{ __('vehicles.actions') }}</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                                @forelse ($vehicles as $vehicle)
                                    <tr
                                        class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-slate-800 dark:hover:to-slate-700 transition-all duration-300 transform hover:scale-[1.01]">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                                    @if ($vehicle->photo)
                                                        <a href="{{ asset('storage/' . $vehicle->photo) }}"
                                                            data-fancybox="vehicle-photo" class="block">
                                                            <img src="{{ asset('storage/' . $vehicle->photo) }}"
                                                                alt="{{ __('Vehicle Photo') }}"
                                                                class="w-12 h-12 object-cover rounded-full border border-gray-300 shadow-sm hover:shadow-md transition duration-200">
                                                        </a>
                                                    @else
                                                        <div
                                                            class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-lg shadow-lg">
                                                            <i class="fas fa-car text-white text-xl"></i>
                                                        </div>
                                                    @endif

                                                    <div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                            {{ $vehicle->plate_category }}
                                                        </div>
                                                        <div class="text-lg font-black text-slate-900 dark:text-white">
                                                            {{ $vehicle->plate_number }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                       <td class="px-6 py-5 whitespace-nowrap">
    <div class="text-sm font-medium text-slate-900 dark:text-white">
        {{ $vehicle->brand }}
    </div>
    <div class="text-sm text-slate-500 dark:text-slate-300">
        {{ $vehicle->model }}
    </div>
</td>

                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                @if ($vehicle->user)
                                                    @if ($vehicle->user->photo_url)
                                                        <a href="{{ asset($vehicle->user->photo_url) }}"
                                                            data-fancybox="user-photo" class="block">
                                                            <img src="{{ asset($vehicle->user->photo_url) }}"
                                                                alt="{{ $vehicle->user->name }}"
                                                                class="w-8 h-8 object-cover rounded-full border border-gray-300 shadow-sm hover:shadow-md transition duration-200">
                                                        </a>
                                                    @else
                                                        <div
                                                            class="bg-gradient-to-br from-emerald-500 to-green-600 p-1.5 rounded-full">
                                                            <svg class="w-3 h-3 text-white" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="text-sm font-medium text-slate-900 dark:text-white">{{ $vehicle->user->name }}</span>
                                                @else
                                                    <div
                                                        class="bg-gradient-to-br from-slate-400 to-slate-500 p-1.5 rounded-full">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    </div>
                                                    <span
                                                        class="text-sm text-slate-500 dark:text-slate-400">{{ __('vehicles.no_driver') }}</span>
                                                @endif
                                            </div>


                                        </td>
                                        @php
                                            $licenseDaysLeft = \Carbon\Carbon::now()->diffInDays(
                                                $vehicle->license_expiry_date,
                                                false,
                                            );
                                            $insuranceDaysLeft = \Carbon\Carbon::now()->diffInDays(
                                                $vehicle->insurance_expiry_date,
                                                false,
                                            );

                                            $licenseIsUrgent = $licenseDaysLeft <= 30 && $licenseDaysLeft >= 0;
                                            $insuranceIsUrgent = $insuranceDaysLeft <= 30 && $insuranceDaysLeft >= 0;
                                        @endphp


                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @if ($vehicle->license_expiry_date)
                                                <div
                                                    class="px-3 py-2 rounded-lg {{ $licenseIsUrgent
                                                        ? 'bg-red-300 dark:bg-red-900'
                                                        : 'bg-gradient-to-br from-blue-200 to-indigo-200 dark:from-blue-900 dark:to-indigo-900' }}">
                                                    <div
                                                        class="text-sm font-medium {{ $licenseIsUrgent ? 'text-red-800 dark:text-red-200' : 'text-blue-800 dark:text-blue-200' }}">
                                                        {{ $vehicle->license_expiry_date->format('Y-m-d') }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-slate-400 dark:text-slate-500">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @if ($vehicle->insurance_expiry_date)
                                                <div
                                                    class="px-3 py-2 rounded-lg {{ $insuranceIsUrgent
                                                        ? 'bg-red-300 dark:bg-red-900'
                                                        : 'bg-gradient-to-br from-blue-200 to-indigo-200 dark:from-blue-900 dark:to-indigo-900' }}">
                                                    <div
                                                        class="text-sm font-medium {{ $insuranceIsUrgent ? 'text-red-800 dark:text-red-200' : 'text-purple-800 dark:text-purple-200' }}">
                                                        {{ $vehicle->insurance_expiry_date->format('Y-m-d') }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-slate-400 dark:text-slate-500">-</span>
                                            @endif
                                        </td>


                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @php
                                                $status = $vehicle->status;
                                                $statusColor = match ($status) {
                                                    'available' => 'bg-green-600',
                                                    'in_service' => 'bg-yellow-600',
                                                    'broken' => 'bg-red-600',
                                                    default => 'bg-gray-500',
                                                };
                                            @endphp

                                            <span
                                                class="inline-flex items-center px-3 py-2 text-xs font-bold rounded-full shadow-lg text-white {{ $statusColor }}">
                                                <div
                                                    class="w-2 h-2 rounded-full bg-white/30 mr-2 rtl:mr-0 rtl:ml-2 animate-pulse">
                                                </div>
                                                {{ __('vehicles.status_' . $status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                                <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                                    class="group relative bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white p-2 rounded-lg transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <div
                                                        class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap">
                                                        {{ __('vehicles.view') }}
                                                    </div>
                                                </a>

                                                <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                    class="group relative bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white p-2 rounded-lg transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <div
                                                        class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap">
                                                        {{ __('vehicles.edit') }}
                                                    </div>
                                                </a>

                                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('{{ __('vehicles.delete_confirm') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="group relative bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white p-2 rounded-lg transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <div
                                                            class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap">
                                                            {{ __('vehicles.delete') }}
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center space-y-4">
                                                <div
                                                    class="bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 p-6 rounded-full">
                                                    <svg class="w-16 h-16 text-slate-400 dark:text-slate-500"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </div>
                                                <div class="text-center">
                                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                                        {{ __('vehicles.no_vehicles') }}</h3>
                                                    <p class="text-slate-500 dark:text-slate-400 mb-6">
                                                        {{ __('vehicles.no_vehicles_desc') }}</p>
                                                    <a href="{{ route('vehicles.create') }}"
                                                        class="inline-flex items-center space-x-2 rtl:space-x-reverse bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        <span>{{ __('vehicles.add_vehicle') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Enhanced Mobile & Tablet Card View -->
            <div class="xl:hidden grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($vehicles as $vehicle)
                    <div
                        class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/30 overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">

                        <!-- Enhanced Card Header -->
                        <div
                            class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-xl shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                                            {{ $vehicle->plate_category }} {{ $vehicle->plate_number }}
                                        </h3>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $vehicle->brand }}</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center px-3 py-2 text-xs font-bold rounded-full shadow-lg
                                @if ($vehicle->status === 'active') bg-gradient-to-r from-emerald-500 to-green-500 text-white
                                @elseif($vehicle->status === 'inactive') bg-gradient-to-r from-red-500 to-rose-500 text-white
                                @else bg-gradient-to-r from-amber-500 to-orange-500 text-white @endif">
                                    <div class="w-2 h-2 rounded-full bg-white/30 mr-2 rtl:mr-0 rtl:ml-2 animate-pulse">
                                    </div>
                                    {{ __('vehicles.status_' . $vehicle->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Enhanced Card Body -->
                        <div class="p-6 space-y-4">

                            <!-- Driver Info -->
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 rounded-xl">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="bg-gradient-to-br from-emerald-500 to-green-600 p-2 rounded-lg">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p
                                            class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                            {{ __('vehicles.driver') }}</p>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">
                                            {{ $vehicle->user->name ?? __('vehicles.no_driver') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- License & Insurance -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div
                                    class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p
                                            class="text-xs font-medium text-blue-800 dark:text-blue-300 uppercase tracking-wider">
                                            {{ __('vehicles.license_expiry_date') }}</p>
                                    </div>
                                    <p class="text-sm font-bold text-blue-900 dark:text-blue-100">
                                        {{ $vehicle->license_expiry_date ? $vehicle->license_expiry_date->format('Y-m-d') : '-' }}
                                    </p>
                                </div>

                                <div
                                    class="p-4 bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl border border-purple-200 dark:border-purple-800">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <p
                                            class="text-xs font-medium text-purple-800 dark:text-purple-300 uppercase tracking-wider">
                                            {{ __('vehicles.insurance_expiry_date') }}</p>
                                    </div>
                                    <p class="text-sm font-bold text-purple-900 dark:text-purple-100">
                                        {{ $vehicle->insurance_expiry_date ? $vehicle->insurance_expiry_date->format('Y-m-d') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Card Actions -->
                        <div
                            class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                    class="flex-1 group relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center py-3 px-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                    </div>
                                    <div class="relative flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>{{ __('vehicles.view') }}</span>
                                    </div>
                                </a>

                                <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                    class="flex-1 group relative overflow-hidden bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white text-center py-3 px-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                    </div>
                                    <div class="relative flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>{{ __('vehicles.edit') }}</span>
                                    </div>
                                </a>

                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('{{ __('vehicles.delete_confirm') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full group relative overflow-hidden bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white py-3 px-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                        </div>
                                        <div
                                            class="relative flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>{{ __('vehicles.delete') }}</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div
                            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/30 p-12 text-center">
                            <div class="flex flex-col items-center space-y-6">
                                <div
                                    class="bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 p-8 rounded-full">
                                    <svg class="w-20 h-20 text-slate-400 dark:text-slate-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                                <div class="text-center space-y-4">
                                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                                        {{ __('vehicles.no_vehicles') }}</h3>
                                    <p class="text-slate-500 dark:text-slate-400 max-w-md">
                                        {{ __('vehicles.no_vehicles_desc') }}</p>
                                    <a href="{{ route('vehicles.create') }}"
                                        class="inline-flex items-center space-x-3 rtl:space-x-reverse bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span>{{ __('vehicles.add_vehicle') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Enhanced Pagination -->
            @if ($vehicles->hasPages())
                <div class="mt-12">
                    <div
                        class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/30 p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                {{ __('Showing') }}
                                <span
                                    class="font-semibold text-slate-900 dark:text-white">{{ $vehicles->firstItem() }}</span>
                                {{ __('to') }}
                                <span
                                    class="font-semibold text-slate-900 dark:text-white">{{ $vehicles->lastItem() }}</span>
                                {{ __('of') }}
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $vehicles->total() }}</span>
                                {{ __('results') }}
                            </div>
                            <div class="pagination-wrapper">
                                {{ $vehicles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            /* Enhanced Animations */
            @keyframes slide-down {
                from {
                    opacity: 0;
                    transform: translateY(-20px) scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes bounce-in {
                0% {
                    transform: scale(0.3);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.05);
                }

                70% {
                    transform: scale(0.9);
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .animate-slide-down {
                animation: slide-down 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }

            .animate-bounce-in {
                animation: bounce-in 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }

            /* Glass Effect */
            .glass-effect {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }

            /* Dark mode glass effect */
            .dark .glass-effect {
                background: rgba(30, 41, 59, 0.25);
                border: 1px solid rgba(100, 116, 139, 0.18);
            }

            /* Enhanced RTL Support */
            [dir="rtl"] .flex {
                flex-direction: row-reverse;
            }

            [dir="rtl"] .text-start {
                text-align: right;
            }

            [dir="rtl"] .space-x-2> :not([hidden])~ :not([hidden]) {
                --tw-space-x-reverse: 1;
                margin-right: calc(0.5rem * var(--tw-space-x-reverse));
                margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
            }

            [dir="rtl"] .space-x-3> :not([hidden])~ :not([hidden]) {
                --tw-space-x-reverse: 1;
                margin-right: calc(0.75rem * var(--tw-space-x-reverse));
                margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse)));
            }

            [dir="rtl"] .space-x-4> :not([hidden])~ :not([hidden]) {
                --tw-space-x-reverse: 1;
                margin-right: calc(1rem * var(--tw-space-x-reverse));
                margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)));
            }

            /* Custom Scrollbar */
            .overflow-x-auto::-webkit-scrollbar {
                height: 8px;
            }

            .overflow-x-auto::-webkit-scrollbar-track {
                background: linear-gradient(90deg, #f1f5f9, #e2e8f0);
                border-radius: 8px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb {
                background: linear-gradient(90deg, #94a3b8, #64748b);
                border-radius: 8px;
                border: 2px solid #f1f5f9;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(90deg, #64748b, #475569);
            }

            /* Dark mode scrollbar */
            .dark .overflow-x-auto::-webkit-scrollbar-track {
                background: linear-gradient(90deg, #1e293b, #334155);
            }

            .dark .overflow-x-auto::-webkit-scrollbar-thumb {
                background: linear-gradient(90deg, #475569, #64748b);
                border-color: #1e293b;
            }

            .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(90deg, #64748b, #94a3b8);
            }

            /* Enhanced Pagination Styling */
            .pagination-wrapper .pagination {
                display: flex;
                align-items: center;
                space-x: 0.5rem;
            }

            .pagination-wrapper .pagination a,
            .pagination-wrapper .pagination span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 2.5rem;
                height: 2.5rem;
                padding: 0.5rem;
                border-radius: 0.75rem;
                font-weight: 500;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                margin: 0 0.125rem;
            }

            .pagination-wrapper .pagination a {
                background: linear-gradient(135deg, #f8fafc, #f1f5f9);
                color: #475569;
                border: 1px solid #e2e8f0;
                text-decoration: none;
            }

            .pagination-wrapper .pagination a:hover {
                background: linear-gradient(135deg, #3b82f6, #6366f1);
                color: white;
                transform: scale(1.05);
                box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
            }

            .pagination-wrapper .pagination .active span {
                background: linear-gradient(135deg, #3b82f6, #6366f1);
                color: white;
                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            }

            .pagination-wrapper .pagination .disabled span {
                background: #f8fafc;
                color: #cbd5e1;
                cursor: not-allowed;
            }

            /* Dark mode pagination */
            .dark .pagination-wrapper .pagination a {
                background: linear-gradient(135deg, #1e293b, #334155);
                color: #94a3b8;
                border-color: #475569;
            }

            .dark .pagination-wrapper .pagination a:hover {
                background: linear-gradient(135deg, #3b82f6, #6366f1);
                color: white;
            }

            .dark .pagination-wrapper .pagination .disabled span {
                background: #1e293b;
                color: #475569;
            }

            /* Mobile optimizations */
            @media (max-width: 640px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .text-3xl {
                    font-size: 1.875rem;
                }

                .text-4xl {
                    font-size: 2.25rem;
                }
            }

            /* Micro-interactions */
            .hover-lift {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            /* Loading states */
            .loading-shimmer {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading-shimmer 1.5s infinite;
            }

            @keyframes loading-shimmer {
                0% {
                    background-position: -200% 0;
                }

                100% {
                    background-position: 200% 0;
                }
            }

            .dark .loading-shimmer {
                background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
                background-size: 200% 100%;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add loading states to buttons
                const actionButtons = document.querySelectorAll('a[href*="vehicles"], button[type="submit"]');

                actionButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        if (this.tagName === 'BUTTON' && this.type === 'submit') {
                            const form = this.closest('form');
                            if (form && !form.onsubmit || (form.onsubmit && form.onsubmit())) {
                                this.disabled = true;
                                this.innerHTML =
                                    '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
                            }
                        }
                    });
                });

                // Enhance table row interactions
                const tableRows = document.querySelectorAll('tbody tr');
                tableRows.forEach(row => {
                    row.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.01)';
                    });

                    row.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                });

                // Add smooth scrolling to pagination
                const paginationLinks = document.querySelectorAll('.pagination a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
