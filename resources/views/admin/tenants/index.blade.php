@extends('layouts.app')

@section('content')
    <div class="mx-4 py-4 sm:mx-auto max-w-screen-2xl" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        {{-- ✅ العنوان وزر الإضافة --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ __('messages.tenants_list') }}</h1>

            @can('create tenants')
                <a href="{{ route('admin.tenants.create') }}"
                    class="flex-shrink-0 bg-green-600 hover:bg-green-700 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center w-12 h-12 sm:w-auto sm:h-auto sm:px-4 sm:py-2 sm:rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline ml-2">{{ __('messages.add_tenant') }}</span>
                </a>
            @endcan
        </div>

        {{-- ✅ فلتر البحث الذكي --}}
        <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <form method="GET" class="flex flex-col sm:flex-row gap-3" id="smartSearchForm">
                <div class="relative flex-1">
                    <div
                        class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="{{ __('messages.search_placeholder') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10' : 'pl-10' }} py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>{{ __('messages.search') }}</span>
                </button>
            </form>
        </div>

        {{-- ✅ عرض المستأجرين --}}
        @if ($tenants->isEmpty())
            <div
                class="max-w-screen-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-100 dark:border-gray-700 text-center text-gray-500 dark:text-gray-400">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-3 text-lg">{{ __('messages.no_tenants') }}</p>
                @can('create tenants')
                    <a href="{{ route('admin.tenants.create') }}"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        {{ __('messages.add_first_tenant') }}
                    </a>
                @endcan
            </div>
        @else
            <div
                class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('messages.full_name') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">
                                    {{ __('messages.id_number') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('messages.phone') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">
                                    {{ __('messages.unit_number') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell">
                                    {{ __('messages.created_at') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('messages.status') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden xl:table-cell">
                                    {{ __('messages.has_debt') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden xl:table-cell">
                                    {{ __('messages.has_account') }}</th>
                                <th
                                    class="px-6 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden 2xl:table-cell">
                                    {{ __('messages.tenant_type') }}</th>
                                <th
                                    class="px-6 py-4 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($tenants as $tenant)
                               @php
    $status = $tenant->tenant_status;
    $colors = [
        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'late_payer' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'has_debt' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        'absent' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'abroad' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'legal_issue' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
        'blocked' => 'bg-black text-white dark:bg-black dark:text-white', // ✅ الجديد
    ];
@endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $tenant->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 sm:hidden">
                                                    {{ $tenant->id_number ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                        {{ $tenant->id_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="tel:{{ $tenant->phone }}"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $tenant->phone ?? '-' }}
                                            </a>
                                            <a href="tel:{{ $tenant->phone }}"
                                                class="sm:hidden text-green-600 hover:text-green-800 p-1 rounded-full hover:bg-green-50 dark:hover:bg-green-900/20"
                                                title="{{ __('messages.call') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden md:table-cell">
                                        @if ($tenant->activeContracts->isNotEmpty())
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($tenant->activeContracts as $contract)
                                                    @if ($contract->unit)
                                                        <span
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 text-xs font-bold dark:bg-blue-900 dark:text-blue-200">
                                                            {{ $contract->unit->unit_number }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden lg:table-cell">
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $tenant->created_at->format('Y-m-d') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ __('messages.tenant_status_' . $status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm hidden xl:table-cell">
                                        @if ($tenant->debt > 0)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300">
                                                {{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                                {{ __('messages.no') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm hidden xl:table-cell">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium {{ $tenant->user ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                            {{ $tenant->user ? __('messages.yes') : __('messages.no') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm hidden 2xl:table-cell">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium 
        {{ $tenant->family_type === 'family'
            ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300'
            : 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                            {{ $tenant->family_type === 'family' ? __('messages.family') : __('messages.individual') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex justify-center items-center gap-2">
                                            {{-- زر العرض --}}
                                            @can('view full tenant details')
                                                <a href="{{ route('admin.tenants.show', $tenant->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 p-1 rounded-full hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                                    title="{{ __('messages.view') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            {{-- زر التعديل --}}
                                            @can('edit tenants')
                                                <a href="{{ route('admin.tenants.edit', $tenant->id) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 p-1 rounded-full hover:bg-yellow-50 dark:hover:bg-yellow-900/20"
                                                    title="{{ __('messages.edit') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            {{-- زر الربط مع حساب --}}
                                            @if (!$tenant->user)
                                                @can('link tenant to user')
                                                    <a href="{{ route('admin.tenants.link-user', $tenant->id) }}"
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 p-1 rounded-full hover:bg-green-50 dark:hover:bg-green-900/20"
                                                        title="{{ __('messages.link_to_account') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                    </a>
                                                @endcan
                                            @endif
                                            {{-- زر الحذف --}}
                                            @can('delete tenants')
                                                <form action="{{ route('admin.tenants.destroy', $tenant->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                                                        title="{{ __('messages.delete') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ✅ الترقيم --}}
            <div
                class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                {{ $tenants->onEachSide(1)->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const input = document.getElementById('searchInput');
                let timeout = null;

                // البحث التلقائي بعد التوقف عن الكتابة
                input.addEventListener('input', () => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        document.getElementById('smartSearchForm').submit();
                    }, 500);
                });

                // التركيز على حقل البحث عند تحميل الصفحة
                input.focus();
            });
        </script>
    @endpush
@endsection
