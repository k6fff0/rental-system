@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4">

    {{-- 🏢 بيانات الوحدة --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ __('messages.unit_details') }}</h2>

        @php
            $statusColors = [
                'available' => ['bg' => 'bg-green-200', 'text' => 'text-green-800'],
                'occupied' => ['bg' => 'bg-red-200', 'text' => 'text-red-800'],
                'booked' => ['bg' => 'bg-purple-200', 'text' => 'text-purple-800'],
                'maintenance' => ['bg' => 'bg-yellow-200', 'text' => 'text-yellow-800'],
                'cleaning' => ['bg' => 'bg-indigo-200', 'text' => 'text-indigo-800'],
            ];
            $color = $statusColors[$unit->status] ?? ['bg' => 'bg-gray-200', 'text' => 'text-gray-800'];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div><strong>{{ __('messages.unit_number') }}:</strong> {{ $unit->unit_number }}</div>
            <div><strong>{{ __('messages.unit_type') }}:</strong> {{ __('messages.' . $unit->unit_type) }}</div>
            <div><strong>{{ __('messages.floor') }}:</strong> {{ $unit->floor ?? '-' }}</div>
            <div>
                <strong>{{ __('messages.status') }}:</strong>
                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $color['bg'] }} {{ $color['text'] }}">
                    {{ __('messages.' . $unit->status) }}
                </span>
            </div>
            <div><strong>{{ __('messages.rent_price') }}:</strong> {{ number_format($unit->rent_price) }} {{ __('messages.currency') }}</div>
            <div><strong>{{ __('messages.building') }}:</strong> {{ $unit->building->name }}</div>
        </div>
    </div>

    {{-- 👤 المستأجر الحالي --}}
    @if ($unit->status === 'occupied' && $unit->latestContract && $unit->latestContract->tenant)
        <div class="bg-blue-50 rounded-lg shadow p-6 mb-6 border border-blue-200">
            <h3 class="text-xl font-bold mb-3 text-blue-800">{{ __('messages.current_tenant') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><strong>{{ __('messages.tenant_name') }}:</strong> {{ $unit->latestContract->tenant->name }}</div>
                <div><strong>{{ __('messages.tenant_phone') }}:</strong> {{ $unit->latestContract->tenant->phone ?? '-' }}</div>
                <div><strong>{{ __('messages.contract_start') }}:</strong> {{ $unit->latestContract->start_date }}</div>
                <div><strong>{{ __('messages.contract_end') }}:</strong> {{ $unit->latestContract->end_date }}</div>
            </div>
        </div>
    @endif

   {{-- 📄 العقود السابقة --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-bold mb-4 text-gray-800">{{ __('messages.contract_history') }}</h3>

    @if ($unit->contracts->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">{{ __('messages.tenant_name') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('messages.contract_start') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('messages.contract_end') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('messages.rent_price') }}</th>
                        <th class="px-4 py-2 text-left">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($unit->contracts->sortByDesc('start_date') as $contract)
                        <tr>
                            <td class="px-4 py-2">{{ $contract->tenant->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $contract->start_date }}</td>
                            <td class="px-4 py-2">{{ $contract->end_date }}</td>
                            <td class="px-4 py-2">{{ number_format($contract->rent_amount) }} {{ __('messages.currency') }}</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.contracts.show', $contract->id) }}"
                                       class="text-blue-600 hover:text-blue-800 text-xs inline-flex items-center">
                                        👁️ {{ __('messages.view') }}
                                    </a>
                                    <a href="{{ route('admin.contracts.print', $contract->id) }}"
                                       target="_blank"
                                       class="text-gray-600 hover:text-gray-800 text-xs inline-flex items-center">
                                        🖨️ {{ __('messages.print') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">{{ __('messages.no_contracts_found') }}</p>
    @endif
</div>


</div>
@endsection
