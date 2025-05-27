@extends('layouts.app')

@section('title', __('messages.building_details'))

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ✅ العنوان --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.building_details') }}</h1>
        <a href="{{ route('admin.buildings.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← {{ __('messages.back_to_buildings') }}
        </a>
    </div>

    {{-- ✅ تفاصيل المبنى --}}
    <div class="bg-white p-6 rounded-lg shadow space-y-6 text-sm text-gray-700">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div><strong>{{ __('messages.building_name') }}:</strong> {{ $building->name }}</div>
            <div><strong>{{ __('messages.address') }}:</strong> {{ $building->address }}</div>

            {{-- رابط الموقع --}}
            @php
                $locationUrl = is_string($building->location_url) ? trim($building->location_url) : '';
            @endphp
            <div>
                <strong>{{ __('messages.location_url') }}:</strong>
                @if (!empty($locationUrl) && filter_var($locationUrl, FILTER_VALIDATE_URL))
                    <a href="{{ $locationUrl }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ __('messages.view_on_map') }}
                    </a>
                @else
                    -
                @endif
            </div>

            <div><strong>{{ __('messages.owner_name') }}:</strong> {{ $building->owner_name ?? '-' }}</div>
            <div><strong>{{ __('messages.owner_nationality') }}:</strong> {{ $building->owner_nationality ?? '-' }}</div>
            <div><strong>{{ __('messages.owner_id') }}:</strong> {{ $building->owner_id_number ?? '-' }}</div>
            <div><strong>{{ __('messages.owner_phone') }}:</strong> {{ $building->owner_phone ?? '-' }}</div>
            <div><strong>{{ __('messages.municipality_number') }}:</strong> {{ $building->municipality_number ?? '-' }}</div>
            <div><strong>{{ __('messages.rent_amount') }}:</strong> 
                {{ $building->rent_amount ? number_format($building->rent_amount, 2) . ' ' . __('messages.aed') : '-' }}
            </div>
            <div><strong>{{ __('messages.initial_renovation_cost') }}:</strong> 
                {{ $building->initial_renovation_cost ? number_format($building->initial_renovation_cost, 2) . ' ' . __('messages.aed') : '-' }}
            </div>
            <div><strong>{{ __('messages.units_count') }}:</strong> {{ $building->units()->count() }}</div>
            <div><strong>{{ __('messages.created_at') }}:</strong> {{ $building->created_at?->format('Y-m-d') ?? '-' }}</div>
        </div>

        {{-- ✅ جدول المرافق --}}
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.utilities_list') }}</h2>

            @if ($building->utilities->count())
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-right">#</th>
                                <th class="px-4 py-2 text-right">{{ __('messages.utility_type') }}</th>
                                <th class="px-4 py-2 text-right">{{ __('messages.utility_value') }}</th>
                                <th class="px-4 py-2 text-right">{{ __('messages.owner_name') }}</th>
                                <th class="px-4 py-2 text-right">{{ __('messages.notes') }}</th>
                                <th class="px-4 py-2 text-right">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($building->utilities as $utility)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ __('messages.' . $utility->type) }}</td>
                                    <td class="px-4 py-2">{{ $utility->value }}</td>
                                    <td class="px-4 py-2">{{ $utility->owner_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($utility->notes, 30) }}</td>
                                    <td class="px-4 py-2 space-x-2 text-left">
                                        <a href="{{ route('admin.building-utilities.show', $utility->id) }}"
                                           class="text-green-600 hover:underline">
                                            {{ __('messages.view') }}
                                        </a>
                                        <a href="{{ route('admin.building-utilities.edit', $utility->id) }}"
                                           class="text-blue-600 hover:underline">
                                            {{ __('messages.edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-500">{{ __('messages.no_utilities') }}</p>
            @endif
        </div>

        {{-- زر تعديل --}}
        <div class="text-left pt-4">
            <a href="{{ route('admin.buildings.edit', $building->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow transition">
                {{ __('messages.edit_building') }}
            </a>
        </div>
    </div>
</div>
@endsection
