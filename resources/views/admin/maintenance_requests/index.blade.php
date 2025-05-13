@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🔧 العنوان --}}
    <div class="bg-blue-100 text-blue-800 p-6 rounded-lg shadow-md mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-2xl font-bold">{{ __('messages.maintenance_requests') }}</h1>
        </div>
        <a href="{{ route('admin.maintenance_requests.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-semibold shadow-md transition duration-300 whitespace-nowrap">
            + {{ __('messages.add_new_request') }}
        </a>
    </div>

    {{-- 🔍 الفلاتر --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-center">
            {{-- المبنى --}}
            <div class="relative">
                <select name="building_id" class="border rounded px-3 py-2 pr-8 text-sm appearance-none focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('messages.filter_by_building') }}</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- الحالة --}}
            <div class="relative">
                <select name="status" class="border rounded px-3 py-2 pr-8 text-sm appearance-none focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('messages.filter_by_status') }}</option>
                    @foreach (['new','in_progress','completed','rejected','delayed','waiting_materials','customer_unavailable','other'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ __('messages.status_' . $status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- نوع العطل --}}
            <div class="relative">
                <select name="category_id" class="border rounded px-3 py-2 pr-8 text-sm appearance-none focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('messages.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ __('maintenance_categories.' . $category->slug) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 🔢 بحث برقم الغرفة --}}
            <div class="relative">
                <input 
                    type="text" 
                    name="unit_number" 
                    placeholder="{{ __('messages.search_by_unit_number') }}"
                    value="{{ request('unit_number') }}"
                    class="border rounded px-3 py-2 text-sm w-40 focus:ring-2 focus:ring-blue-500"
                    oninput="this.form.submit()"
                >
            </div>
        </form>
    </div>

    {{-- 📋 جدول الطلبات --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">{{ __('messages.requests_table') }}</h2>
            <p class="text-sm text-gray-500">{{ __('messages.total_requests') }}: {{ $requests->count() }}</p>
        </div>
        <table class="min-w-full border border-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">{{ __('messages.status') }}</th>
                    <th class="px-4 py-3">{{ __('messages.id') }}</th>
                    <th class="px-4 py-3">{{ __('messages.building') }}</th>
                    <th class="px-4 py-3">{{ __('messages.unit') }}</th>
                    <th class="px-4 py-3">{{ __('messages.category') }}</th>
                    <th class="px-4 py-3">{{ __('messages.technician') }}</th>
                    <th class="px-4 py-3">{{ __('messages.actions') }}</th>
                    <th class="px-4 py-3">{{ __('messages.change_status') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    @php
                        $colors = [
                            'new' => 'bg-yellow-400 animate-pulse',
                            'in_progress' => 'bg-blue-400 animate-pulse',
                            'completed' => 'bg-green-500',
                            'rejected' => 'bg-red-500',
                            'delayed' => 'bg-orange-400',
                            'waiting_materials' => 'bg-purple-400',
                            'customer_unavailable' => 'bg-pink-400',
                            'other' => 'bg-gray-400',
                        ];
                    @endphp
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <span class="inline-block w-3 h-3 rounded-full {{ $colors[$request->status] ?? 'bg-gray-300' }}" title="{{ __('messages.status_' . $request->status) }}"></span>
                        </td>
                        <td class="px-4 py-2">{{ $request->id }}</td>
                        <td class="px-4 py-2">{{ $request->building->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $request->unit->unit_number ?? '-' }}</td>
                        <td class="px-4 py-2">
                            {{ __('maintenance_categories.' . ($request->category->slug ?? 'other')) }}
                        </td>
                        <td class="px-4 py-2">{{ $request->technician->name ?? __('messages.no_technician') }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-2">
                            <a href="{{ route('admin.maintenance_requests.show', $request->id) }}" class="bg-gray-200 px-3 py-1 rounded text-xs hover:bg-gray-300">
                                {{ __('messages.show') }}
                            </a>
                            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                {{ __('messages.edit') }}
                            </a>
                            @if ($request->image)
                                <a href="{{ asset('storage/' . $request->image) }}" target="_blank" class="bg-indigo-600 text-white px-3 py-1 rounded text-xs hover:bg-indigo-700">
                                    {{ __('messages.image') }}
                                </a>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('admin.maintenance_requests.update_status', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    @foreach (['new','in_progress','completed','rejected','delayed','waiting_materials','customer_unavailable','other'] as $status)
                                        <option value="{{ $status }}" {{ $request->status == $status ? 'selected' : '' }}>
                                            {{ __('messages.status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            {{ __('messages.no_requests_found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection