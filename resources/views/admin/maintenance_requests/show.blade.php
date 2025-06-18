 @extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300" 
         dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            
            <!-- Header Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl mb-6 sm:mb-8 overflow-hidden transition-colors duration-300">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800 px-4 sm:px-6 py-6 sm:py-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex-1">
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-3">
                                {{ __('messages.request_details') }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="inline-flex items-center bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-medium text-white">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    #{{ $request->id }}
                                </span>
                                @php
                                    $statusColors = [
                                        'new' => 'bg-blue-500/20 text-blue-100',
                                        'pending' => 'bg-yellow-500/20 text-yellow-100',
                                        'in_progress' => 'bg-orange-500/20 text-orange-100',
                                        'completed' => 'bg-green-500/20 text-green-100',
                                        'rejected' => 'bg-red-500/20 text-red-100',
                                        'delayed' => 'bg-purple-500/20 text-purple-100',
                                    ];
                                    $statusColor = $statusColors[$request->status] ?? 'bg-gray-500/20 text-gray-100';
                                @endphp
                                <span class="inline-flex items-center {{ $statusColor }} backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-medium">
                                    <div class="w-2 h-2 rounded-full bg-current {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }} animate-pulse"></div>
                                    {{ __('messages.status_' . $request->status) ?? $request->status ?? __('messages.new') }}
                                </span>
                                <span class="inline-flex items-center bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-medium text-white">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $request->created_at->format('Y/m/d') }}
                                </span>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
                <!-- Left Column -->
                <div class="xl:col-span-2 space-y-6 lg:space-y-8">

                    <!-- Unit Information Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 px-4 sm:px-6 py-4">
                            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V15a1 1 0 001 1h3a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h3a1 1 0 001-1v-2.586l.293.293a1 1 0 001.414-1.414l-9-9z" />
                                </svg>
                                {{ __('messages.unit_information') }}
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 transition-colors duration-300">
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        {{ __('messages.building') }}
                                    </div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $request->building->name ?? __('messages.not_specified') }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 transition-colors duration-300">
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }} text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ __('messages.unit_number') }}
                                    </div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $request->unit->unit_number ?? __('messages.not_specified') }}
                                    </div>
                                </div>
                            </div>

                            @php
                                $tenant = $request->unit->activeContract->tenant ?? null;
                            @endphp

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 sm:pt-6">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('messages.tenant_information') }}
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 transition-colors duration-300">
                                        <div class="text-sm text-blue-600 dark:text-blue-400 mb-1 flex items-center">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ __('messages.name') }}
                                        </div>
                                        <div class="font-semibold text-blue-900 dark:text-blue-100">{{ $tenant?->name ?? '-' }}</div>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 transition-colors duration-300">
                                        <div class="text-sm text-blue-600 dark:text-blue-400 mb-1 flex items-center">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ __('messages.phone') }}
                                        </div>
                                        <div class="font-semibold text-blue-900 dark:text-blue-100 direction-ltr">
                                            @if($tenant?->phone)
                                                <a href="tel:{{ $tenant->phone }}" class="hover:underline">{{ $tenant->phone }}</a>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if ($request->extra_phone)
                                    <div class="mt-4 bg-green-50 dark:bg-green-900/20 rounded-xl p-4 transition-colors duration-300">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                            <span class="font-medium text-green-700 dark:text-green-300 flex items-center">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                {{ __('messages.extra_phone') }}:
                                            </span>
                                            <div class="flex items-center gap-3">
                                                <a href="tel:{{ $request->extra_phone }}"
                                                   class="text-blue-600 dark:text-blue-400 hover:underline font-medium direction-ltr">
                                                    {{ $request->extra_phone }}
                                                </a>
                                                @if ($request->is_whatsapp)
                                                    <a href="https://wa.me/{{ ltrim($request->extra_phone, '+') }}"
                                                       target="_blank"
                                                       class="inline-flex items-center gap-1 text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors duration-200">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.309"/>
                                                        </svg>
                                                        WhatsApp
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
								@if ($request->audio_note)
    <div class="mt-6">
        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
            🎧 {{ __('messages.audio_note') ?? 'ملاحظة صوتية' }}
        </label>

        <audio controls class="mt-2 w-full">
            <source src="{{ asset('storage/' . $request->audio_note) }}" type="audio/webm">
            {{ __('messages.your_browser_does_not_support_audio') ?? 'متصفحك لا يدعم تشغيل الصوت' }}
        </audio>
    </div>
@endif

                            </div>
                        </div>
                    </div>

                    <!-- Issue Details Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 dark:from-orange-600 dark:to-red-700 px-4 sm:px-6 py-4">
                            <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                {{ __('messages.issue_details') }}
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-4 transition-colors duration-300">
                                    <div class="text-sm text-orange-600 dark:text-orange-400 mb-1 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        {{ __('messages.issue_type') }}
                                    </div>
                                    <div class="font-semibold text-orange-900 dark:text-orange-100">
                                        {{ $request->subSpecialty->name ?? __('messages.not_specified') }}
                                    </div>
                                </div>
                                <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-4 transition-colors duration-300">
                                    <div class="text-sm text-orange-600 dark:text-orange-400 mb-1 flex items-center">
                                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        {{ __('messages.main_specialty') }}
                                    </div>
                                    <div class="font-semibold text-orange-900 dark:text-orange-100">
                                        {{ $request->subSpecialty->parent->name ?? __('messages.not_specified') }}
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 transition-colors duration-300">
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-2 flex items-center">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('messages.problem_description') }}
                                </div>
                                <div class="text-gray-900 dark:text-gray-100 leading-relaxed whitespace-pre-line">
                                    {{ $request->description ?? __('messages.no_description_available') }}
                                </div>
                            </div>

                            @if($request->status === 'rejected' && $request->rejection_note)
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 transition-colors duration-300">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <div>
                                            <h3 class="font-semibold text-red-800 dark:text-red-200 mb-1">
                                                {{ __('messages.rejection_note') }}
                                            </h3>
                                            <p class="text-red-700 dark:text-red-300 whitespace-pre-line">
                                                {{ $request->rejection_note }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($request->status === 'delayed' && $request->note)
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 transition-colors duration-300">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-1">
                                                {{ __('messages.delay_note') }}
                                            </h3>
                                            <p class="text-yellow-700 dark:text-yellow-300 whitespace-pre-line">
                                                {{ $request->note }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 transition-colors duration-300">
                                <div class="text-sm text-green-600 dark:text-green-400 mb-1 flex items-center">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    {{ __('messages.estimated_cost') }}
                                </div>
                                <div class="flex items-baseline gap-2">
                                    <span class="font-bold text-2xl sm:text-3xl text-green-700 dark:text-green-300">
                                        {{ number_format($request->cost ?? 0) }}
                                    </span>
                                    <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                        {{ __('messages.aed') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images Section -->

                    @if ($request->image || $request->completed_image)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 dark:from-purple-600 dark:to-pink-700 px-4 sm:px-6 py-4">
                                <h2 class="text-lg sm:text-xl font-bold text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('messages.attached_images') }}
                                </h2>
                            </div>
                            <div class="p-4 sm:p-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    @if ($request->image)
                                        <div class="space-y-3">
                                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                                <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                                                {{ __('messages.initial_report_image') }}
                                            </h3>
                                            <div class="relative group overflow-hidden rounded-xl">
                                                <a href="{{ asset('storage/' . $request->image) }}" 
                                                   data-fancybox="gallery" 
                                                   data-caption="{{ __('messages.initial_report_image') }}">
                                                    <img src="{{ asset('storage/' . $request->image) }}" 
                                                         alt="{{ __('messages.initial_report_image') }}"
                                                         class="w-full h-48 sm:h-56 lg:h-64 object-cover border-2 border-gray-200 dark:border-gray-600 group-hover:border-purple-300 dark:group-hover:border-purple-500 transition-all duration-300 cursor-pointer">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                        <div class="absolute bottom-4 left-4 right-4">
                                                            <div class="flex items-center justify-between text-white">
                                                                <span class="text-sm font-medium">{{ __('messages.click_to_enlarge') }}</span>
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($request->completed_image)
                                        <div class="space-y-3">
                                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                                <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                                {{ __('messages.completion_image') }}
                                            </h3>
                                            <div class="relative group overflow-hidden rounded-xl">
                                                <a href="{{ asset('storage/' . $request->completed_image) }}" 
                                                   data-fancybox="gallery" 
                                                   data-caption="{{ __('messages.completion_image') }}">
                                                    <img src="{{ asset('storage/' . $request->completed_image) }}" 
                                                         alt="{{ __('messages.completion_image') }}"
                                                         class="w-full h-48 sm:h-56 lg:h-64 object-cover border-2 border-gray-200 dark:border-gray-600 group-hover:border-purple-300 dark:group-hover:border-purple-500 transition-all duration-300 cursor-pointer">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                        <div class="absolute bottom-4 left-4 right-4">
                                                            <div class="flex items-center justify-between text-white">
                                                                <span class="text-sm font-medium">{{ __('messages.click_to_enlarge') }}</span>
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6 lg:space-y-8">

                    <!-- Technician Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 dark:from-indigo-600 dark:to-blue-700 px-4 sm:px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                {{ __('messages.technician_information') }}
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6 space-y-4">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-3">
                                    @if($request->technician && $request->technician->photo_url)
                                        <img src="{{ $request->technician->photo_url }}" 
                                             alt="{{ $request->technician->name }}"
                                             class="w-full h-full rounded-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                    {{ $request->technician->name ?? __('messages.not_assigned_yet') }}
                                </h3>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    {{ __('messages.assigned_technician') }}
                                </div>
                                @if($request->technician && $request->technician->phone)
                                    <a href="tel:{{ $request->technician->phone }}" 
                                       class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $request->technician->phone }}
                                    </a>
                                @endif
                            </div>

                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-3 text-center transition-colors duration-300">
                                <div class="text-xs text-indigo-600 dark:text-indigo-400 mb-1 flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    {{ __('messages.assignment_method') }}
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $request->assigned_manually ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' }}">
                                    {{ $request->assigned_manually ? __('messages.manual') : __('messages.automatic') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                        <div class="bg-gradient-to-r from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 px-4 sm:px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                {{ __('messages.timeline') }}
                            </h2>
                        </div>
                        <div class="p-4 sm:p-6">
                            <div class="space-y-4">
                                <!-- Created -->
                                @if ($request->created_at)
                                    <div class="flex items-start gap-3 relative">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 relative z-10">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 pb-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ __('messages.request_created') }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                {{ $request->created_at->format('Y/m/d H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ __('messages.by') }}: {{ $request->creator->name ?? __('messages.not_specified') }}
                                            </div>
                                        </div>
                                        <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                    </div>
                                @endif

                                <!-- In Progress -->
                                @if ($request->in_progress_at)
                                    <div class="flex items-start gap-3 relative">
                                        <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 relative z-10">
                                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 pb-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ __('messages.work_started') }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                {{ \Carbon\Carbon::parse($request->in_progress_at)->format('Y/m/d H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ __('messages.by') }}: {{ $request->inProgressBy->name ?? __('messages.not_specified') }}
                                            </div>
                                        </div>
                                        <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                    </div>
                                @endif

                                <!-- Delayed -->
                                @if ($request->delayed_at)
                                    <div class="flex items-start gap-3 relative">
                                        <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 relative z-10">
                                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 pb-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ __('messages.work_delayed') }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                {{ \Carbon\Carbon::parse($request->delayed_at)->format('Y/m/d H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ __('messages.by') }}: {{ $request->delayedBy->name ?? __('messages.not_specified') }}
                                            </div>
                                        </div>
                                        <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                    </div>
                                @endif

                                <!-- Completed -->
                                @if ($request->completed_at)
                                    <div class="flex items-start gap-3 relative">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 relative z-10">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 pb-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ __('messages.work_completed') }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                {{ \Carbon\Carbon::parse($request->completed_at)->format('Y/m/d H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ __('messages.by') }}: {{ $request->completedBy->name ?? __('messages.not_specified') }}
                                            </div>
                                        </div>
                                        <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                                    </div>
                                @endif

                                <!-- Rejected -->
                                @if ($request->rejected_at)
                                    <div class="flex items-start gap-3 relative">
                                        <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 relative z-10">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ __('messages.request_rejected') }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                {{ \Carbon\Carbon::parse($request->rejected_at)->format('Y/m/d H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ __('messages.by') }}: {{ $request->rejectedBy->name ?? __('messages.not_specified') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Smooth transitions for dark mode */
        * {
            transition-property: background-color, border-color, color, fill, stroke, box-shadow;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Direction override for phone numbers */
        .direction-ltr {
            direction: ltr;
            text-align: left;
        }

        [dir="rtl"] .direction-ltr {
            text-align: right;
        }

        /* Custom scrollbar for dark mode */
        .dark ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .dark ::-webkit-scrollbar-track {
            @apply bg-gray-800;
        }

        .dark ::-webkit-scrollbar-thumb {
            @apply bg-gray-600 rounded-lg;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-500;
        }

        /* Light mode scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            @apply bg-gray-100;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 rounded-lg;
        }

        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400;
        }

        /* Timeline line styles */
        .timeline-line {
            background: linear-gradient(to bottom, #e5e7eb, #e5e7eb);
        }

        .dark .timeline-line {
            background: linear-gradient(to bottom, #374151, #374151);
        }

        /* Card hover effects */
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .card-hover:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        /* Image hover effects */
        .image-hover {
            overflow: hidden;
        }

        .image-hover img {
            transition: transform 0.3s ease;
        }

        .image-hover:hover img {
            transform: scale(1.05);
        }

        /* Status animation */
        @keyframes statusPulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .status-pulse {
            animation: statusPulse 2s infinite;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .max-w-7xl {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .text-2xl {
                font-size: 1.5rem;
                line-height: 2rem;
            }

            .text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem;
            }

            .space-y-6 > * + * {
                margin-top: 1.5rem;
            }
        }

        /* Landscape mobile optimization */
        @media (max-height: 500px) and (orientation: landscape) {
            .py-6 {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }

            .py-8 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .space-y-8 > * + * {
                margin-top: 1rem;
            }
        }

        /* Enhanced focus states */
        .focus-visible:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .dark .focus-visible:focus {
            outline-color: #60a5fa;
        }

        /* Fancybox dark mode support */
        .dark .fancybox-bg {
            background: rgba(0, 0, 0, 0.9) !important;
        }

        .dark .fancybox-toolbar {
            background: rgba(0, 0, 0, 0.8) !important;
        }

        .dark .fancybox-caption {
            background: rgba(0, 0, 0, 0.8) !important;
            color: white !important;
        }
    </style>

    <!-- Include Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <!-- Include Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Fancybox
            Fancybox.bind("[data-fancybox]", {
                // Options
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [
                            "zoomIn",
                            "zoomOut",
                            "toggle1to1",
                            "rotateCCW",
                            "rotateCW",
                            "flipX",
                            "flipY",
                        ],
                        right: ["slideshow", "thumbs", "close"],
                    },
                },
                Images: {
                    zoom: true,
                },
                Thumbs: {
                    autoStart: false,
                },
            });

            // Add card hover effects
            const cards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            cards.forEach(card => {
                card.classList.add('card-hover');
            });

            // Add image hover effects
            const imageContainers = document.querySelectorAll('[data-fancybox]');
            imageContainers.forEach(container => {
                container.classList.add('image-hover');
            });

            // Add status pulse animation
            const statusBadges = document.querySelectorAll('.animate-pulse');
            statusBadges.forEach(badge => {
                badge.classList.add('status-pulse');
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Quick back with Ctrl+B
                if (e.ctrlKey && e.key === 'b') {
                    e.preventDefault();
                    window.history.back();
                }

                // Print with Ctrl+P
                if (e.ctrlKey && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe cards for stagger animation
            const animatedElements = document.querySelectorAll('.bg-white.dark\\:bg-gray-800, .timeline-item');
            animatedElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(element);
            });

            // Timeline items animation
            const timelineItems = document.querySelectorAll('.flex.items-start.gap-3');
            timelineItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                item.style.transition = `opacity 0.6s ease ${index * 0.2}s, transform 0.6s ease ${index * 0.2}s`;
                
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 200);
            });

            // Smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Print styles
            const printStyles = `
                @media print {
                    .bg-gradient-to-r {
                        background: #3b82f6 !important;
                        color: white !important;
                    }
                    .shadow-lg, .shadow-xl {
                        box-shadow: none !important;
                        border: 1px solid #e5e7eb !important;
                    }
                    .rounded-2xl {
                        border-radius: 0.5rem !important;
                    }
                    .space-y-6 > * + * {
                        margin-top: 1rem !important;
                    }
                    .grid {
                        break-inside: avoid;
                    }
                    img {
                        max-height: 200px !important;
                        width: auto !important;
                    }
                }
            `;
            
            const styleSheet = document.createElement('style');
            styleSheet.textContent = printStyles;
            document.head.appendChild(styleSheet);

            // Enhanced accessibility
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('focus', function() {
                    this.style.outline = '2px solid #3b82f6';
                    this.style.outlineOffset = '2px';
                });
                
                link.addEventListener('blur', function() {
                    this.style.outline = 'none';
                });
            });

            // Auto-refresh status every 30 seconds (optional)
            // Uncomment the following lines if you want auto-refresh
            /*
            setInterval(() => {
                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Check if status has changed
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newStatus = doc.querySelector('[class*="status_"]');
                    const currentStatus = document.querySelector('[class*="status_"]');
                    
                    if (newStatus && currentStatus && newStatus.textContent !== currentStatus.textContent) {
                        // Show notification that status has changed
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                        notification.textContent = 'تم تحديث حالة البلاغ';
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.remove();
                            window.location.reload();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.log('Auto-refresh failed:', error);
                });
            }, 30000);
            */

            // Copy link functionality
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    showNotification('تم نسخ الرابط', 'success');
                }).catch(() => {
                    showNotification('فشل في نسخ الرابط', 'error');
                });
            }

            // Show notification
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${
                    type === 'success' ? 'bg-green-600 text-white' : 
                    type === 'error' ? 'bg-red-600 text-white' : 
                    'bg-blue-600 text-white'
                }`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Add copy button for request ID (optional)
            const requestId = document.querySelector('[class*="#"]');
            if (requestId) {
                requestId.style.cursor = 'pointer';
                requestId.title = 'انقر لنسخ رقم البلاغ';
                requestId.addEventListener('click', function() {
                    const id = this.textContent.replace('#', '');
                    copyToClipboard(id);
                });
            }

            // Lazy loading for images
            const images = document.querySelectorAll('img[src]');
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });

            // Enhanced error handling for images
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = document.createElement('div');
                    placeholder.className = 'w-full h-48 sm:h-56 lg:h-64 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center';
                    placeholder.innerHTML = `
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm">فشل في تحميل الصورة</p>
                        </div>
                    `;
                    this.parentNode.replaceChild(placeholder, this);
                });
            });
        });

        // Global functions for external use
        window.refreshPage = function() {
            window.location.reload();
        };

        window.printPage = function() {
            window.print();
        };

        window.sharePage = function() {
            if (navigator.share) {
                navigator.share({
                    title: 'تفاصيل البلاغ #' + document.querySelector('[class*="#"]')?.textContent?.replace('#', '') || '',
                    url: window.location.href
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showNotification('تم نسخ رابط الصفحة', 'success');
                });
            }
        };
    </script>
@endsection