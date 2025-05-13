@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🔧 العنوان --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 flex items-center gap-3">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h1 class="text-xl font-bold text-blue-800">{{ __('messages.maintenance_requests') }}</h1>
    </div>

    {{-- 🔍 الفلاتر --}}
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form method="GET" class="flex flex-wrap gap-4 items-center flex-1">
            {{-- المبنى --}}
            <div class="relative">
                <select name="building_id" class="border rounded px-3 py-2 pr-8 text-sm appearance-none">
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
                <select name="status" class="border rounded px-3 py-2 pr-8 text-sm appearance-none">
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
                <select name="category_id" class="border rounded px-3 py-2 pr-8 text-sm appearance-none">
                    <option value="">{{ __('messages.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ __('maintenance_categories.' . $category->slug) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 🔢 بحث برقم الغرفة --}}
            <div>
                <input type="text" name="unit_number" placeholder="{{ __('messages.search_by_unit_number') }}"
                    value="{{ request('unit_number') }}"
                    class="border rounded px-3 py-2 text-sm w-40">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                {{ __('messages.search') }}
            </button>
        </form>

        <a href="{{ route('admin.maintenance_requests.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-semibold shadow-md transition duration-300 whitespace-nowrap">
            + {{ __('messages.add_new_request') }}
        </a>
    </div>

    {{-- 📋 جدول الطلبات --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-100 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                <tr>
                    <th class="px-4 py-3">{{ __('messages.status') }}</th>
                    <th class="px-4 py-3">{{ __('messages.id') }}</th>
                    <th class="px-4 py-3">{{ __('messages.building') }}</th>
                    <th class="px-4 py-3">{{ __('messages.unit') }}</th>
                    <th class="px-4 py-3">{{ __('messages.category') }}</th>
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
                            <span class="inline-block w-3 h-3 rounded-full {{ $colors[$request->status] ?? 'bg-gray-300' }}"></span>
                        </td>
                        <td class="px-4 py-2">{{ $request->id }}</td>
                        <td class="px-4 py-2">{{ $request->building->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $request->unit->unit_number ?? '-' }}</td>
                        <td class="px-4 py-2">
                            {{ __('maintenance_categories.' . ($request->category->slug ?? 'other')) }}
                        </td>
                        <td class="px-4 py-2 flex flex-wrap gap-2">
                            <a href="{{ route('admin.maintenance_requests.show', $request->id) }}" class="bg-gray-200 px-3 py-1 rounded text-xs">
                                {{ __('messages.show') }}
                            </a>
                            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                {{ __('messages.edit') }}
                            </a>
                            @if ($request->image)
                                <a href="{{ asset('storage/' . $request->image) }}" target="_blank" class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">
                                    {{ __('messages.image') }}
                                </a>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('admin.maintenance_requests.update_status', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded">
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
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            {{ __('messages.no_requests_found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
