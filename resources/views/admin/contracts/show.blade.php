@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

            {{-- ✅ العنوان وزر الرجوع --}}
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 me-3 text-blue-500 dark:text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('messages.contract_details') }}
                        </h1>
                        <p class="text-base text-gray-500 dark:text-gray-400 mt-2">
                            {{ __('messages.contract_number') }}: <span class="font-bold text-blue-600 dark:text-blue-400">{{ $contract->contract_number }}</span>
                        </p>
                    </div>
                    <a href="{{ route('admin.contracts.index') }}"
                        class="inline-flex items-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('messages.back_to_contracts') }}
                    </a>
                </div>
            </div>

            {{-- 📊 بطاقات الحالة والمعلومات الأساسية --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                {{-- حالة العقد --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.status') }}</p>
                            <p class="text-2xl font-bold mt-1">
                                @php
                                    $status = $contract->visual_status;
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold
                                    {{ match ($status) {
                                        'expired' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                        'expiring' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
                                        'terminated' => 'bg-gray-100 dark:bg-gray-700/30 text-gray-700 dark:text-gray-300',
                                        default => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                                    } }}">
                                    {{ __('messages.' . $status) }}
                                </span>
                            </p>
                        </div>
                        <div class="p-3 rounded-full {{ match ($status) {
                            'expired' => 'bg-red-100 dark:bg-red-900',
                            'expiring' => 'bg-yellow-100 dark:bg-yellow-900',
                            'terminated' => 'bg-gray-100 dark:bg-gray-700',
                            default => 'bg-green-100 dark:bg-green-900',
                        } }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 {{ match ($status) {
                                'expired' => 'text-red-600 dark:text-red-400',
                                'expiring' => 'text-yellow-600 dark:text-yellow-400',
                                'terminated' => 'text-gray-600 dark:text-gray-400',
                                default => 'text-green-600 dark:text-green-400',
                            } }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($status == 'active')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($status == 'expired')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($status == 'expiring')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                @endif
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- مدة العقد --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.contract_duration') }}</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $contract->formatted_duration }}
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- الإيجار الشهري --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.monthly_rent') }}</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ number_format($contract->rent_amount ?? 0, 0) }}
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.currency') }}</span>
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- الأيام المتبقية --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                       @php
    $days = intval(now()->diffInDays($contract->end_date, false));
@endphp

<p>
    {{ $days < 0 
        ? __('messages.expired') 
        : __('messages.remaining_in', ['days' => $days]) }}
</p>

                        </div>
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ محتوى العقد --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- العمود الأيسر - المعلومات الرئيسية --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- معلومات المستأجر --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('messages.tenant_information') }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.tenant_name') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->tenant->name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.phone') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->tenant->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.email') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->tenant->email ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.national_id') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->tenant->id_number ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- معلومات الوحدة --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-indigo-500 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {{ __('messages.unit_information') }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.unit_number') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->unit->unit_number ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.building') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->unit->building->name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.floor') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->unit->floor ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.unit_type') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->unit->unit_type ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- تفاصيل العقد --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-emerald-500 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('messages.contract_details') }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.start_date') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $contract->start_date->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.end_date') }}</label>
                                <p class="text-base font-semibold {{ $contract->end_date->isPast() ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-gray-100' }} mt-1">
                                    {{ $contract->end_date->format('Y-m-d') }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.payment_frequency') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ __('messages.' . $contract->payment_frequency) ?? __('messages.monthly') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.payment_method') }}</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ __('messages.' . $contract->payment_method) ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- الملاحظات --}}
                    @if ($contract->notes)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-yellow-500 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                {{ __('messages.notes') }}
                            </h3>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $contract->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- العمود الأيمن - الإجراءات والملفات --}}
                <div class="space-y-6">
                    {{-- إجراءات العقد --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('messages.contract_actions') }}</h3>
                        <div class="space-y-3">
                            {{-- طباعة العقد --}}
                            <a href="{{ route('admin.contracts.print', $contract->id) }}"
                                class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-3 rounded-lg font-medium transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                {{ __('messages.print_contract') }}
                            </a>

                            {{-- تعديل العقد --}}
                            @can('edit contracts')
                                <a href="{{ route('admin.contracts.edit', $contract->id) }}"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-4 py-3 rounded-lg font-medium transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('messages.edit_contract') }}
                                </a>
                            @endcan

               
                            {{-- إنهاء العقد --}}
                            @can('end contract')
                                @if (!in_array($contract->visual_status, ['terminated']))
                                    <form action="{{ route('admin.contracts.end', $contract->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            onclick="return confirm('{{ __('messages.confirm_end_contract') }}')"
                                            class="w-full inline-flex items-center justify-center gap-2 bg-orange-600 dark:bg-orange-500 hover:bg-orange-700 dark:hover:bg-orange-600 text-white px-4 py-3 rounded-lg font-medium transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            {{ __('messages.end_contract') }}
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            {{-- حذف العقد --}}
                            @can('delete contracts')
                                <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('{{ __('messages.confirm_delete_contract') }}')"
                                        class="w-full inline-flex items-center justify-center gap-2 bg-red-600 dark:bg-red-500 hover:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-3 rounded-lg font-medium transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        {{ __('messages.delete_contract') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    {{-- المرفقات --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                {{ __('messages.attachments') }}
                            </h3>
                            @can('add contract attachments')
                                <button onclick="document.getElementById('attachmentModal').classList.remove('hidden')"
                                    class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ __('messages.add') }}
                                </button>
                            @endcan
                        </div>

                        @if(optional($contract->unit->images)->isEmpty())
                            <div class="text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('messages.no_attachments') }}</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($contract->attachments ?? [] as $attachment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $icon = match(pathinfo($attachment->file_path, PATHINFO_EXTENSION)) {
                                                    'pdf' => 'file-pdf',
                                                    'doc', 'docx' => 'file-word',
                                                    'xls', 'xlsx' => 'file-excel',
                                                    'jpg', 'jpeg', 'png', 'gif' => 'file-image',
                                                    default => 'file-alt'
                                                };
                                            @endphp
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $attachment->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment->created_at->format('Y-m-d') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-600 p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @can('delete contract attachments')
                                                <form action="{{ route('admin.contracts.attachments.destroy', [$contract->id, $attachment->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete_attachment') }}')" class="text-red-500 hover:text-red-600 p-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- سجل الدفعات --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 me-2 text-green-500 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('messages.payment_history') }}
                        </h3>
                        
                      @if($contract->payments->isEmpty())
    <div class="text-center py-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('messages.no_payments_found') }}</p>
    </div>
@else
    <div class="space-y-4">
        @foreach($contract->payments->sortByDesc('payment_date') as $payment)
            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-start">
                    {{-- الجانب الأيسر/الأساسي: المبلغ + التاريخ --}}
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-200">
                            {{ number_format($payment->amount) }} {{ __('messages.currency') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $payment->payment_date->format('Y-m-d') }}
                        </p>

                        @if($payment->notes)
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $payment->notes }}</p>
                        @endif
                    </div>

                    {{-- الجانب المقابل: اسم المُحصِّل --}}
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                            {{ __('messages.collected_by') }}
                        </p>
                        <p class="text-sm text-gray-800 dark:text-gray-100 font-semibold">
                            {{ $payment->collector?->name ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لإضافة مرفق -->
    <div id="attachmentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ __('messages.add_attachment') }}</h3>
                <button onclick="document.getElementById('attachmentModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
			@if(Route::has('admin.contracts.attachments.store') && isset($contract))
            <form action="{{ route('admin.contracts.attachments.store', $contract->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="attachment_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.attachment_name') }}</label>
                    <input type="text" name="name" id="attachment_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div class="mb-4">
                    <label for="attachment_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.file') }}</label>
                    <input type="file" name="file" id="attachment_file" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.allowed_file_types') }}</p>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('attachmentModal').classList.add('hidden')" class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md">
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
			@endif
        </div>
    </div>
@endsection
