@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/20 py-4 px-2 sm:px-4 lg:px-8 transition-all duration-500"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        {{-- Enhanced Header Section --}}
        <div
            class="bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 dark:from-purple-700 dark:via-indigo-700 dark:to-blue-700 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-2xl mx-2 sm:mx-4 relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                    <defs>
                        <pattern id="tech-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="10" cy="10" r="1" fill="white" opacity="0.5" />
                            <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" opacity="0.3" />
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#tech-grid)" />
                </svg>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative z-10">
                <div class="w-full sm:w-auto">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2">
                                {{ __('messages.technician_profile') }}</h1>
                            <p class="text-purple-100 dark:text-purple-200 opacity-90 text-base sm:text-lg">
                                {{ __('messages.view_technician_details') }}</p>
                        </div>
                    </div>

                    {{-- Technician Basic Info in Header --}}
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold">{{ $technician->name }}</h2>
                                <p class="text-purple-200 text-sm">
                                    {{ $technician->mainSpecialty->name ?? __('messages.no_specialty') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.technicians.index') }}"
                    class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 border border-white/30">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('messages.back') }}
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-2 sm:px-4">
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

                {{-- Main Content Area --}}
                <div class="xl:col-span-3 space-y-6">

                    {{-- Personal Information Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                {{ __('messages.personal_information') }}
                            </h2>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Name Field --}}
                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2 block">{{ __('messages.full_name') }}</label>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 group-hover:border-blue-300 dark:group-hover:border-blue-500 transition-all duration-200">
                                        <div
                                            class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $technician->name }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Email Field --}}
                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2 block">{{ __('messages.email') }}</label>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 group-hover:border-green-300 dark:group-hover:border-green-500 transition-all duration-200">
                                        <div class="text-lg text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="break-all">{{ $technician->email }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Phone Field --}}
                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2 block">{{ __('messages.phone') }}</label>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 group-hover:border-purple-300 dark:group-hover:border-purple-500 transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="text-lg text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span>{{ $technician->phone ?? '-' }}</span>
                                            </div>
                                            @if ($technician->phone)
                                                <a href="tel:{{ $technician->phone }}"
                                                    class="bg-green-100 dark:bg-green-900/30 hover:bg-green-200 dark:hover:bg-green-900/50 text-green-600 dark:text-green-400 p-2 rounded-lg transition-all duration-200 hover:scale-105"
                                                    title="{{ __('messages.call') }}">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Main Specialty Field --}}
                                <div class="group">
                                    <label
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2 block">{{ __('messages.main_specialty') }}</label>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 group-hover:border-indigo-300 dark:group-hover:border-indigo-500 transition-all duration-200">
                                        <div class="text-lg text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                                </path>
                                            </svg>
                                            {{ $technician->mainSpecialty->name ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Additional Tasks Section --}}
                            <div class="mt-6">
                                <label
                                    class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3 block">{{ __('messages.additional_tasks') }}</label>
                                @php
                                    $subTasks = $technician->mainSpecialty?->subSpecialties;
                                @endphp
                                @if ($subTasks && $subTasks->isNotEmpty())
                                    <div class="flex flex-wrap gap-3">
                                        @foreach ($subTasks as $task)
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-700 shadow-sm">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ $task->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                        <div
                                            class="text-sm text-gray-500 dark:text-gray-400 italic flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('messages.no_additional_tasks') }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Notes Section --}}
                            @if ($technician->notes)
                                <div class="mt-6">
                                    <label
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3 block">{{ __('messages.notes') }}</label>
                                    <div
                                        class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-200 dark:border-amber-700/50">
                                        <div
                                            class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap text-sm leading-relaxed">
                                            {{ $technician->notes }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Recent Activity Timeline --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/30 dark:to-red-900/30 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                {{ __('messages.recent_activity') }}
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @forelse ($requests->sortByDesc('updated_at') as $req)
                                    @php
                                        $unit = optional($req->unit)->unit_number ?? 'غير معروف';
                                        $sub = optional($req->subSpecialty)->name ?? 'غير محدد';
                                        $time = $req->updated_at->diffForHumans();

                                        switch ($req->status) {
                                            case 'completed':
                                                $color = 'bg-green-500';
                                                $bgColor = 'bg-green-50 dark:bg-green-900/20';
                                                $borderColor = 'border-green-200 dark:border-green-700';
                                                $icon =
                                                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                                $text = "تم إكمال مهمة صيانة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                                                break;
                                            case 'in_progress':
                                                $color = 'bg-yellow-500';
                                                $bgColor = 'bg-yellow-50 dark:bg-yellow-900/20';
                                                $borderColor = 'border-yellow-200 dark:border-yellow-700';
                                                $icon =
                                                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                                $text = "بدأ تنفيذ مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                                                break;
                                            case 'rejected':
                                                $color = 'bg-red-500';
                                                $bgColor = 'bg-red-50 dark:bg-red-900/20';
                                                $borderColor = 'border-red-200 dark:border-red-700';
                                                $icon =
                                                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                                $text = "تم رفض مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                                                break;
                                            case 'new':
                                                $color = 'bg-blue-500';
                                                $bgColor = 'bg-blue-50 dark:bg-blue-900/20';
                                                $borderColor = 'border-blue-200 dark:border-blue-700';
                                                $icon =
                                                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>';
                                                $text = "تم تعيين مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                                                break;
                                            case 'delayed':
                                                $color = 'bg-purple-500';
                                                $bgColor = 'bg-purple-50 dark:bg-purple-900/20';
                                                $borderColor = 'border-purple-200 dark:border-purple-700';
                                                $icon =
                                                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                                $text = "⏳ تم تأجيل مهمة <strong>{$sub}</strong> - الوحدة <strong>{$unit}</strong>";
                                                break;
                                            default:
                                                $color = 'bg-gray-400';
                                                $bgColor = 'bg-gray-50 dark:bg-gray-700/50';
                                                $borderColor = 'border-gray-200 dark:border-gray-600';
                                                $icon =
                                                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                                                $text = "تم تحديث مهمة - الوحدة <strong>{$unit}</strong>";
                                                break;
                                        }
                                    @endphp

                                    <div
                                        class="flex items-start gap-4 p-4 rounded-xl {{ $bgColor }} border {{ $borderColor }} shadow-sm hover:shadow-md transition-all duration-200">
                                        <div
                                            class="flex-shrink-0 flex items-center justify-center w-8 h-8 {{ $color }} rounded-lg text-white">
                                            {!! $icon !!}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {!! $text !!}</p>
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $time }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('messages.no_activity_found') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="xl:col-span-1 space-y-6">

                    {{-- Status Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <div
                                    class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                {{ __('messages.current_status') }}
                            </h3>
                        </div>

                        <div class="p-6">
                            @php
                                $status = $technician->technician_status ?? 'unavailable';
                                $statusConfig = [
                                    'available' => [
                                        'bg' => 'bg-green-100 dark:bg-green-900/30',
                                        'text' => 'text-green-800 dark:text-green-300',
                                        'border' => 'border-green-200 dark:border-green-700',
                                        'icon' =>
                                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                                        'pulse' => 'animate-pulse',
                                    ],
                                    'busy' => [
                                        'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                        'text' => 'text-yellow-800 dark:text-yellow-300',
                                        'border' => 'border-yellow-200 dark:border-yellow-700',
                                        'icon' =>
                                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                        'pulse' => '',
                                    ],
                                    'unavailable' => [
                                        'bg' => 'bg-red-100 dark:bg-red-900/30',
                                        'text' => 'text-red-800 dark:text-red-300',
                                        'border' => 'border-red-200 dark:border-red-700',
                                        'icon' =>
                                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
                                        'pulse' => '',
                                    ],
                                ];
                                $config = $statusConfig[$status] ?? $statusConfig['unavailable'];
                            @endphp

                            <div class="text-center mb-4">
                                <div
                                    class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl {{ $config['bg'] }} {{ $config['text'] }} border-2 {{ $config['border'] }} {{ $config['pulse'] }}">
                                    <div class="flex items-center justify-center">
                                        {!! $config['icon'] !!}
                                    </div>
                                    <span
                                        class="font-bold text-sm">{{ __('messages.technician_status_' . $status) }}</span>
                                </div>
                            </div>

                            {{-- Status Description --}}
                            <div
                                class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                <div class="text-center">
                                    <div
                                        class="text-xs text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide font-semibold">
                                        {{ __('messages.status_description') }}</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100 leading-relaxed">
                                        @switch($status)
                                            @case('available')
                                                {{ __('messages.technician_available_desc') }}
                                            @break

                                            @case('busy')
                                                {{ __('messages.technician_busy_desc') }}
                                            @break

                                            @case('unavailable')
                                                {{ __('messages.technician_unavailable_desc') }}
                                            @break

                                            @default
                                                {{ __('messages.status_unknown') }}
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/30 dark:to-red-900/30 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <div
                                    class="w-6 h-6 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                {{ __('messages.quick_actions') }}
                            </h3>
                        </div>

                        <div class="p-6 space-y-3">
                            {{-- Edit Technician --}}
                            <a href="{{ route('admin.technicians.edit', $technician->id) }}"
                                class="w-full group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} group-hover:rotate-12 transition-transform duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                {{ __('messages.edit_technician') }}
                            </a>

                            {{-- Call Technician --}}
                            @if ($technician->phone)
                                <a href="tel:{{ $technician->phone }}"
                                    class="w-full group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} group-hover:rotate-12 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ __('messages.call_technician') }}
                                </a>
                            @endif

                            {{-- Email Technician --}}
                            @if ($technician->email)
                                <a href="mailto:{{ $technician->email }}"
                                    class="w-full group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} group-hover:rotate-12 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ __('messages.send_email') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Statistics Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 border border-gray-200 dark:border-gray-700">
                        <div
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <div
                                    class="w-6 h-6 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                {{ __('messages.statistics') }}
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                {{-- Total Tasks --}}
                                <div
                                    class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        {{ __('messages.total_tasks') }}
                                    </span>
                                    <span
                                        class="font-bold text-blue-600 dark:text-blue-400 text-lg">{{ $total }}</span>
                                </div>

                                {{-- Completed Tasks --}}
                                <div
                                    class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        {{ __('messages.completed_tasks') }}
                                    </span>
                                    <span
                                        class="font-bold text-green-600 dark:text-green-400 text-lg">{{ $completed }}</span>
                                </div>

                                {{-- In Progress Tasks --}}
                                <div
                                    class="flex justify-between items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-200 dark:border-yellow-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        {{ __('messages.in_progress_tasks') }}
                                    </span>
                                    <span
                                        class="font-bold text-yellow-600 dark:text-yellow-400 text-lg">{{ $in_progress }}</span>
                                </div>

                                {{-- New Tasks --}}
                                <div
                                    class="flex justify-between items-center p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-200 dark:border-indigo-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-indigo-500 rounded-full"></div>
                                        {{ __('messages.new_tasks') }}
                                    </span>
                                    <span
                                        class="font-bold text-indigo-600 dark:text-indigo-400 text-lg">{{ $new }}</span>
                                </div>

                                {{-- Rejected Tasks --}}
                                <div
                                    class="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        {{ __('messages.rejected_tasks') }}
                                    </span>
                                    <span
                                        class="font-bold text-red-600 dark:text-red-400 text-lg">{{ $rejected }}</span>
                                </div>

                                {{-- Success Rate --}}
                                <div class="pt-4 border-t-2 border-gray-200 dark:border-gray-600">
                                    <div
                                        class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl border border-purple-200 dark:border-purple-700">
                                        <span
                                            class="text-sm font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            {{ __('messages.success_rate') }}
                                        </span>
                                        <span class="font-bold text-purple-600 dark:text-purple-400 text-xl">
                                            {{ $total > 0 ? round(($completed / $total) * 100, 1) : 0 }}%
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Detailed Report Button --}}
                            <div class="mt-6">
                                <a href="{{ route('admin.technicians.report', $technician->id) }}"
                                    class="w-full group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} group-hover:rotate-12 transition-transform duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    {{ __('messages.view_detailed_statistics') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced intersection observer with stagger animation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };





            // Enhanced phone link interactions
            const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
            phoneLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add haptic feedback for mobile
                    if ('vibrate' in navigator) {
                        navigator.vibrate([50, 30, 50]);
                    }

                    // Visual feedback with ripple effect
                    const ripple = document.createElement('div');
                    ripple.className = 'absolute inset-0 bg-white/30 rounded-full scale-0';
                    ripple.style.animation = 'ripple 0.6s ease-out';

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Add ripple animation CSS
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
                
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);

            // Mobile-specific optimizations
            if (window.innerWidth <= 768) {
                // Add touch feedback for mobile interactions
                const interactiveElements = document.querySelectorAll('a, button');
                interactiveElements.forEach(element => {
                    element.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.98)';
                    });

                    element.addEventListener('touchend', function() {
                        this.style.transform = 'scale(1)';

                        // Add haptic feedback
                        if ('vibrate' in navigator) {
                            navigator.vibrate(10);
                        }
                    });
                });
            }

            // Enhanced status indicator animation
            const statusIndicator = document.querySelector('.animate-pulse');
            if (statusIndicator) {
                setInterval(() => {
                    statusIndicator.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        statusIndicator.style.transform = 'scale(1)';
                    }, 200);
                }, 2000);
            }

            // Add loading states for action buttons
            const actionButtons = document.querySelectorAll('a[href*="edit"], a[href*="report"]');
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const originalContent = this.innerHTML;
                    this.innerHTML = `
                        <svg class="w-5 h-5 animate-spin {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    `;

                    // Restore original content after navigation (fallback)
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                    }, 3000);
                });
            });
        });
    </script>
@endsection
