@extends('layouts.app')

@section('title', __('messages.building_details'))

@push('styles')
    <style>
        /* أنماط إضافية إذا لزم الأمر */
        .details-grid>div {
            padding-top: 0.75rem;
            /* 12px */
            padding-bottom: 0.75rem;
            /* 12px */
            border-bottom-width: 1px;
            border-color: #e5e7eb;
            /* gray-200 */
        }

        .dark .details-grid>div {
            border-color: #374151;
            /* gray-700 */
        }

        .details-grid>div:last-child {
            border-bottom-width: 0;
        }

        @media (min-width: 640px) {

            /* sm breakpoint */
            .details-grid.sm\:grid-cols-2>div:nth-child(odd) {
                border-right-width: 1px;
                padding-right: 1rem;
                /* 16px */
            }

            .dark .details-grid.sm\:grid-cols-2>div:nth-child(odd) {
                border-color: #374151;
                /* gray-700 */
            }

            .details-grid.sm\:grid-cols-2>div:nth-child(even) {
                padding-left: 1rem;
                /* 16px */
            }

            /* إزالة الحدود السفلية لآخر صفين في حال وجود عمودين */
            .details-grid.sm\:grid-cols-2>div:nth-last-child(-n+2) {
                border-bottom-width: 0;
            }
        }

        @media (min-width: 1024px) {

            /* lg breakpoint */
            .details-grid.lg\:grid-cols-3>div {
                border-right-width: 1px;
                padding-right: 1rem;
                padding-left: 1rem;
            }

            .details-grid.lg\:grid-cols-3>div:nth-child(3n) {
                /* كل ثالث عنصر */
                border-right-width: 0;
                padding-right: 0;
            }

            .details-grid.lg\:grid-cols-3>div:nth-child(3n+1) {
                /* كل أول عنصر في الصف الجديد */
                padding-left: 0;
            }

            /* إزالة الحدود السفلية لآخر ثلاثة عناصر في حال وجود ثلاثة أعمدة */
            .details-grid.lg\:grid-cols-3>div:nth-last-child(-n+3) {
                border-bottom-width: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        {{-- ✅ Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.building_details') }}</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                {{ __('messages.dashboard') }}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('admin.buildings.index') }}"
                                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ __('messages.buildings') }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span
                                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ $building->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.buildings.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-150">

                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd"></path>
                    </svg>

                    {{ __('messages.back_to_buildings') }}
                </a>

                <a href="{{ route('admin.buildings.edit', $building->id) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-150">
                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd"
                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('messages.edit_building') }}
                </a>
            </div>
        </div>
        {{-- ✅ بطاقة تفاصيل المبنى الرئيسية --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8">
                {{-- قسم المعلومات الأساسية --}}
                <div class="mb-8">
                    <h2
                        class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        {{ __('messages.general_information') }}
                    </h2>
                    <div class="details-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 text-sm">
                        @php
                            $generalInfo = [
                                'building_name' => $building->name,
                                'building_number' => $building->building_number,
                                'address' => $building->address,
                                'municipality_number' => $building->municipality_number,
                                'units_count' => $building->units()->count(),
                                'created_at' => $building->created_at?->format('Y-m-d H:i A'),
                            ];
                        @endphp
                        @foreach ($generalInfo as $key => $value)
                            <div class="flex justify-between items-start">
                                <strong
                                    class="text-gray-600 dark:text-gray-400 font-medium">{{ __('messages.' . $key) }}:</strong>
                                <span
                                    class="text-gray-800 dark:text-gray-200 text-right {{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }}">{{ $value ?? '-' }}</span>
                            </div>
                        @endforeach

                        {{-- رابط الموقع --}}
                        @php
                            $locationUrl = is_string($building->location_url) ? trim($building->location_url) : '';
                        @endphp
                        <div class="flex justify-between items-center">
                            <strong
                                class="text-gray-600 dark:text-gray-400 font-medium">{{ __('messages.location_url') }}:</strong>
                            @if (!empty($locationUrl) && filter_var($locationUrl, FILTER_VALIDATE_URL))
                                <a href="{{ $locationUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline transition-colors duration-150">
                                    {{ __('messages.view_on_map') }}
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'mr-1 transform rotate-180' : 'ml-1' }}"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0l-4-4a2 2 0 012.828-2.828L8 7.172l2.586-2.586z"
                                            clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd"
                                            d="M6.414 11.414a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l4-4a1 1 0 10-1.414-1.414L9 12.586l-2.586-2.586z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- قسم معلومات المالك --}}
                <div class="mb-8">
                    <h2
                        class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        {{ __('messages.owner_information') }}
                    </h2>
                    <div class="details-grid grid grid-cols-1 sm:grid-cols-2 gap-x-6 text-sm">
                        @php
                            $ownerInfo = [
                                'owner_name' => $building->owner_name,
                                'owner_nationality' => $building->owner_nationality,
                                'owner_id_number' => $building->owner_id_number, // تأكد من أن هذا المفتاح موجود في ملفات الترجمة
                                'owner_phone' => $building->owner_phone,
                            ];
                        @endphp
                        @foreach ($ownerInfo as $key => $value)
                            <div class="flex justify-between items-start">
                                <strong
                                    class="text-gray-600 dark:text-gray-400 font-medium">{{ __('messages.' . $key) }}:</strong>
                                <span
                                    class="text-gray-800 dark:text-gray-200 text-right {{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }}">{{ $value ?? '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- قسم المعلومات المالية --}}
                <div>
                    <h2
                        class="text-xl font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                        {{ __('messages.financial_information') }}
                    </h2>
                    <div class="details-grid grid grid-cols-1 sm:grid-cols-2 gap-x-6 text-sm">
                        @php
                            $financialInfo = [
                                'rent_amount' => $building->rent_amount
                                    ? number_format($building->rent_amount, 2) . ' ' . __('messages.aed')
                                    : null,
                                'initial_renovation_cost' => $building->initial_renovation_cost
                                    ? number_format($building->initial_renovation_cost, 2) . ' ' . __('messages.aed')
                                    : null,
                            ];
                        @endphp
                        @foreach ($financialInfo as $key => $value)
                            <div class="flex justify-between items-start">
                                <strong
                                    class="text-gray-600 dark:text-gray-400 font-medium">{{ __('messages.' . $key) }}:</strong>
                                <span
                                    class="text-gray-800 dark:text-gray-200 text-right {{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }}">{{ $value ?? '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- زر التعديل في تذييل البطاقة --}}
            <div
                class="bg-gray-50 dark:bg-gray-750 px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }} border-t border-gray-200 dark:border-gray-700">
            </div>

            {{-- ✅ Utilities Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md detail-card overflow-hidden">

                {{-- 🔷 Card Header --}}
                <div class="px-6 py-5 border-b section-divider">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-md bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    {{ __('messages.utilities_list') }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('messages.all_utilities_associated_with_this_building') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔽 Card Body --}}
                @if ($building->utilities->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-750">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                        {{ __('messages.utility_type') }}</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                        {{ __('messages.utility_value') }}</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                        {{ __('messages.owner_name') }}</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                        {{ __('messages.notes') }}</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider {{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }}">
                                        {{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($building->utilities as $index => $utility)
                                    <tr
                                        class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                            {{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ __('messages.' . $utility->type) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $utility->value }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                            {{ $utility->owner_name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300 max-w-xs truncate"
                                            title="{{ $utility->notes }}">
                                            {{ Str::limit($utility->notes, 35) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap {{ app()->getLocale() === 'ar' ? 'text-left' : 'text-right' }} space-x-2 rtl:space-x-reverse">
                                            {{-- 👁 View --}}
                                            <a href="{{ route('admin.building-utilities.show', $utility->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 dark:bg-green-700 dark:text-green-100 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800 transition">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd"
                                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ __('messages.view') }}
                                            </a>

                                            {{-- ✏️ Edit --}}
                                            <a href="{{ route('admin.building-utilities.edit', $utility->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 dark:bg-blue-700 dark:text-blue-100 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                {{ __('messages.edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- 🕳 لا يوجد مرافق --}}
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('messages.no_utilities_found') }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.get_started_by_adding_a_new_utility') }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    @endsection

    @push('scripts')
        {{-- <script>
    // أي سكربتات JavaScript مخصصة إذا لزم الأمر
</script> --}}
    @endpush
