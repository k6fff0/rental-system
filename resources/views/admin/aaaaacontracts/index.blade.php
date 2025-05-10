@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('messages.contracts') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('messages.contracts_description') }}</p>
        </div>

        <div class="flex gap-3">
            <div class="relative">
                <select id="filter-status" class="appearance-none bg-gray-100 border border-gray-300 rounded-md ps-3 pe-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">{{ __('messages.all_statuses') }}</option>
                    <option value="active">{{ __('messages.active') }}</option>
                    <option value="expired">{{ __('messages.expired') }}</option>
                    <option value="expiring">{{ __('messages.expiring_soon') }}</option>
                </select>
                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'start-0 ps-2' : 'end-0 pe-2' }} flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <a href="{{ route('contracts.create') }}"
               class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold shadow transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('messages.add_contract') }}
            </a>
        </div>
    </div>

    {{-- بقية المحتوى بدون تعديل البنية --}}
    @yield('contracts_table')
</div>

<script>
    document.getElementById('filter-status').addEventListener('change', function () {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
