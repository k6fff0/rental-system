@extends('layouts.app')

@section('content')
<div class="p-4">
    <!-- بطاقات الفلاتر -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div onclick="filterBy('all')" class="cursor-pointer bg-white p-4 rounded-lg shadow border-l-4 border-blue-500 hover:bg-blue-100">
            <h3 class="font-bold text-gray-600">{{ __('messages.total_units') }}</h3>
            <p class="text-2xl">{{ $units->count() }}</p>
        </div>
        <div onclick="filterBy('available')" class="cursor-pointer bg-white p-4 rounded-lg shadow border-l-4 border-green-500 hover:bg-green-50">
            <h3 class="font-bold text-gray-600">{{ __('messages.available_units') }}</h3>
            <p class="text-2xl">{{ $units->where('status', 'available')->count() }}</p>
        </div>
        <div onclick="filterBy('occupied')" class="cursor-pointer bg-white p-4 rounded-lg shadow border-l-4 border-red-500 hover:bg-red-50">
            <h3 class="font-bold text-gray-600">{{ __('messages.occupied_units') }}</h3>
            <p class="text-2xl">{{ $units->where('status', 'occupied')->count() }}</p>
        </div>
        <div onclick="filterBy('maintenance')" class="cursor-pointer bg-white p-4 rounded-lg shadow border-l-4 border-yellow-500 hover:bg-yellow-50">
            <h3 class="font-bold text-gray-600">{{ __('messages.maintenance_units') }}</h3>
            <p class="text-2xl">{{ $units->where('status', 'maintenance')->count() }}</p>
        </div>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">{{ __('messages.unit_list') }}</h1>

        <div class="flex space-x-2">
            <select id="statusFilter" class="border rounded px-3 py-1 text-sm">
                <option value="all">{{ __('messages.all_statuses') }}</option>
                <option value="available">{{ __('messages.status_available') }}</option>
                <option value="occupied">{{ __('messages.status_occupied') }}</option>
                <option value="maintenance">{{ __('messages.status_maintenance') }}</option>
            </select>

            <a href="{{ route('admin.units.create') }}" class="bg-green-500 text-white px-4 py-2 rounded inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('messages.add_unit') }}
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.building') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.unit_number') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.floor') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.type') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.status') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.tenant') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.details') }}</th>
                    <th class="px-4 py-2 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                @foreach($units as $unit)
                @php
                    $daysLeft = $unit->contract_end_date
                        ? now()->diffInDays(\Carbon\Carbon::parse($unit->contract_end_date), false)
                        : null;
                @endphp
                <tr class="hover:bg-gray-50 transition" data-status="{{ $unit->status }}">
                    <td class="px-4 py-3">{{ $unit->building->name }}</td>
                    <td class="px-4 py-3 font-medium">{{ $unit->unit_number }}</td>
                    <td class="px-4 py-3">{{ $unit->floor }}</td>
                    <td class="px-4 py-3">{{ $unit->type }}</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.units.updateStatus', $unit->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-xs w-full {{ app()->getLocale() === 'ar' ? 'pr-6 text-right' : '' }}">
                                <option value="available" {{ $unit->status == 'available' ? 'selected' : '' }}>{{ __('messages.status_available') }}</option>
                                <option value="occupied" {{ $unit->status == 'occupied' ? 'selected' : '' }}>{{ __('messages.status_occupied') }}</option>
                                <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>{{ __('messages.status_maintenance') }}</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3">{{ $unit->status === 'occupied' ? ($unit->tenant->name ?? '-') : '-' }}</td>
                    <td class="px-4 py-3">
                        @if($unit->status === 'occupied')
                            <div class="text-sm">
                                <div>{{ __('messages.tenant') }}: {{ $unit->tenant->name ?? 'N/A' }}</div>
                                <div class="{{ $daysLeft < 30 ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $daysLeft > 0 ? $daysLeft.' '.__('messages.days_left') : __('messages.contract_expired') }}
                                </div>
                            </div>
                        @elseif($unit->status === 'maintenance')
                            <div class="text-sm text-yellow-700">
                                {{ $unit->maintenance_notes ?? __('messages.no_notes') }}
                            </div>
                        @else
                            <div class="text-sm text-green-700">
                                {{ __('messages.ready_for_rent') }}
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.units.edit', $unit->id) }}" class="text-blue-600 hover:text-blue-900" title="{{ __('messages.edit') }}">✏️</a>
                            @if($unit->status === 'available')
                                <a href="{{ route('admin.contracts.create', ['unit_id' => $unit->id]) }}" class="text-green-600 hover:text-green-900" title="{{ __('messages.rent_unit') }}">➕</a>
                            @endif
                            <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete') }}')" class="text-red-600 hover:text-red-900" title="{{ __('messages.delete') }}">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('statusFilter').addEventListener('change', function () {
        filterBy(this.value);
    });

    function filterBy(status) {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
        });
        document.getElementById('statusFilter').value = status;
    }
</script>
@endsection
