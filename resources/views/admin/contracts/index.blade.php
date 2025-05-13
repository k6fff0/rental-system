@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 me-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('messages.contracts') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('messages.contracts_description') }}</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-auto">
                <select id="filter-status" class="w-full appearance-none bg-gray-100 border border-gray-300 rounded-md ps-3 pe-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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

            <a href="{{ route('admin.contracts.create') }}"
               class="w-full sm:w-auto flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold shadow transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('messages.add_contract') }}
            </a>
        </div>
    </div>

    {{-- عرض العقود --}}
    @if ($contracts->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __('messages.no_contracts_found') }}
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                            {{ __('messages.tenant') }}
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                            {{ __('messages.unit') }}
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                            {{ __('messages.duration') }}
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                            {{ __('messages.status') }}
                        </th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                            {{ __('messages.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($contracts as $contract)
                        @php
                            $status = now()->gt($contract->end_date)
                                ? 'expired'
                                : (now()->diffInDays($contract->end_date) <= 30 ? 'expiring' : 'active');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-150" data-status="{{ $status }}">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="{{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                                        <p class="text-sm font-medium text-gray-900">{{ $contract->tenant->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        {{ $contract->unit->unit_number ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $contract->start_date->format('Y-m-d') }}</span>
                                        <span class="text-xs text-gray-500">{{ __('messages.to') }}</span>
                                        <span class="{{ $status === 'expired' ? 'text-red-600' : ($status === 'expiring' ? 'text-yellow-600' : 'text-green-600') }} font-medium">
                                            {{ $contract->end_date->format('Y-m-d') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold flex items-center justify-center w-24
                                    {{ $status === 'expired' ? 'bg-red-100 text-red-800' : ($status === 'expiring' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ __('messages.' . $status) }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2 rtl:space-x-reverse">
                                    <a href="{{ route('admin.contracts.edit', $contract->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 p-1 rounded-full hover:bg-indigo-50"
                                       title="{{ __('messages.edit') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                                                class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-50"
                                                title="{{ __('messages.delete') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                    @if ($status !== 'expired')
                                    <form action="{{ route('admin.contracts.end', $contract->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="return confirm('{{ __('messages.confirm_end_contract') }}')"
                                                class="text-orange-600 hover:text-orange-800 p-1 rounded-full hover:bg-orange-50"
                                                title="{{ __('messages.end_contract') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    document.getElementById('filter-status').addEventListener('change', function () {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.classList.remove('hidden');
                row.classList.add('animate-fadeIn');
            } else {
                row.classList.add('hidden');
            }
        });
    });
</script>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection