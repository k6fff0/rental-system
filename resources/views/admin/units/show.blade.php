@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- زر الرجوع -->
        <div class="mb-6">
            <a href="{{ route('admin.units.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}"
                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('messages.back_to_units') }}
            </a>
        </div>

        <!-- بطاقة بيانات الوحدة -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    {{ __('messages.unit_details') }}
                </h2>
            </div>
            <div class="p-6">
                @php
                    $statusColors = [
                        'available' => [
                            'bg' => 'bg-green-100 dark:bg-green-900',
                            'text' => 'text-green-800 dark:text-green-200',
                        ],
                        'occupied' => [
                            'bg' => 'bg-red-100 dark:bg-red-900',
                            'text' => 'text-red-800 dark:text-red-200',
                        ],
                        'booked' => [
                            'bg' => 'bg-purple-100 dark:bg-purple-900',
                            'text' => 'text-purple-800 dark:text-purple-200',
                        ],
                        'maintenance' => [
                            'bg' => 'bg-yellow-100 dark:bg-yellow-900',
                            'text' => 'text-yellow-800 dark:text-yellow-200',
                        ],
                        'cleaning' => [
                            'bg' => 'bg-indigo-100 dark:bg-indigo-900',
                            'text' => 'text-indigo-800 dark:text-indigo-200',
                        ],
                    ];
                    $color = $statusColors[$unit->status] ?? [
                        'bg' => 'bg-gray-100 dark:bg-gray-900',
                        'text' => 'text-gray-800 dark:text-gray-200',
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                            {{ __('messages.unit_number') }}</h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $unit->unit_number }}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.unit_type') }}
                        </h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('messages.' . $unit->unit_type) }}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.floor') }}
                        </h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $unit->floor ?? '-' }}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.status') }}
                        </h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color['bg'] }} {{ $color['text'] }}">
                            {{ __('messages.' . $unit->status) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                            {{ __('messages.rent_price') }}</h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ number_format($unit->rent_price) }} {{ __('messages.currency') }}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.building') }}
                        </h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $unit->building->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- المستأجر الحالي -->
        @if ($unit->status === 'occupied' && $unit->latestContract && $unit->latestContract->tenant)
            <div
                class="bg-blue-50 dark:bg-blue-900 rounded-lg shadow-md overflow-hidden mb-6 border border-blue-200 dark:border-blue-700">
                <div class="px-6 py-4 border-b border-blue-200 dark:border-blue-700">
                    <h3 class="text-xl font-semibold text-blue-800 dark:text-blue-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('messages.current_tenant') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                                {{ __('messages.tenant_name') }}</h3>
                            <p class="text-lg font-semibold text-blue-900 dark:text-white">
                                {{ $unit->latestContract->tenant->name }}</p>
                        </div>

                        <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                                {{ __('messages.tenant_phone') }}</h3>
                            <p class="text-lg font-semibold text-blue-900 dark:text-white">
                                {{ $unit->latestContract->tenant->phone ?? '-' }}</p>
                        </div>

                        <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                                {{ __('messages.contract_start') }}</h3>
                            <p class="text-lg font-semibold text-blue-900 dark:text-white">
                                {{ $unit->latestContract->start_date }}</p>
                        </div>

                        <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                                {{ __('messages.contract_end') }}</h3>
                            <p class="text-lg font-semibold text-blue-900 dark:text-white">
                                {{ $unit->latestContract->end_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- صور الوحدة -->
        @if ($unit->images->count())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ __('messages.unit_images') }}
                    </h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach ($unit->images as $image)
                            <div class="relative group">
                                <a href="{{ asset('storage/' . $image->image_path) }}" data-fancybox="gallery"
                                    class="block">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Unit Image"
                                        class="w-full h-40 object-cover rounded-lg shadow-sm hover:shadow-md transition duration-300">
                                </a>

                                <!-- زر الحذف -->
                                <form action="{{ route('admin.units.images.delete', $image) }}" method="POST"
                                    class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('{{ __('messages.confirm_delete_image') }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs shadow-md">
                                        ×
                                    </button>
                                </form>

                                <!-- خلفية شفافة عند التحويم -->
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition duration-300 pointer-events-none flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- العقود السابقة -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    {{ __('messages.contract_history') }}
                </h3>
            </div>
            <div class="p-6">
                @if ($unit->contracts->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.tenant_name') }}</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.contract_start') }}</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.contract_end') }}</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.rent_price') }}</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($unit->contracts->sortByDesc('start_date') as $contract)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $contract->tenant->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $contract->start_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $contract->end_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ number_format($contract->rent_amount) }} {{ __('messages.currency') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition duration-150">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.contracts.print', $contract->id) }}"
                                                    target="_blank"
                                                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 transition duration-150">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('messages.no_contracts_found') }}</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        Fancybox.bind("[data-fancybox]", {
            Toolbar: true,
            Thumbs: false,
        });
    </script>
@endpush
