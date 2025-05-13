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

            <a href="{{ route('admin.contracts.create') }}"
               class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold shadow transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('messages.add_contract') }}
            </a>
        </div>
    </div>

    {{-- عرض العقود --}}
    @if ($contracts->isEmpty())
        <div class="bg-white p-6 rounded shadow text-center text-gray-500">
            {{ __('messages.no_contracts_found') }}
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.tenant') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.unit') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.duration') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.status') }}</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($contracts as $contract)
                        @php
                            $status = now()->gt($contract->end_date)
                                ? 'expired'
                                : (now()->diffInDays($contract->end_date) <= 30 ? 'expiring' : 'active');
                        @endphp
                        <tr class="hover:bg-gray-50 transition" data-status="{{ $status }}">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $contract->tenant->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $contract->unit->unit_number ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $contract->start_date->format('Y-m-d') }} - {{ $contract->end_date->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $status === 'expired' ? 'bg-red-100 text-red-800' : ($status === 'expiring' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ __('messages.' . $status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center space-x-2 rtl:space-x-reverse">
                                <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="text-indigo-600 hover:text-indigo-900" title="{{ __('messages.edit') }}">✏️</a>

                                <form action="{{ route('admin.contracts.destroy', $contract->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('{{ __('messages.confirm_delete') }}')" class="text-red-600 hover:text-red-900" title="{{ __('messages.delete') }}">🗑️</button>
                                </form>

                                @if ($status !== 'expired')
                                    <form action="{{ route('admin.contracts.end', $contract->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button onclick="return confirm('{{ __('messages.confirm_end_contract') }}')" class="text-orange-600 hover:text-orange-800" title="{{ __('messages.end_contract') }}">⛔</button>
                                    </form>
                                @endif
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
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
