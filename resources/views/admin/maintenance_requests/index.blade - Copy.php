@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🔧 عنوان احترافي --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 flex items-center gap-3">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h1 class="text-xl font-bold text-blue-800">{{ __('messages.maintenance_requests') }}</h1>
    </div>

    {{-- ✅ زر إضافة طلب جديد --}}
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.maintenance_requests.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md text-sm font-semibold shadow-md transition duration-300">
            + {{ __('messages.add_new_request') }}
        </a>
    </div>

    {{-- 🔍 الفلاتر --}}
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-center">
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

        <div class="relative">
            <select name="status" class="border rounded px-3 py-2 pr-8 text-sm appearance-none">
                <option value="">{{ __('messages.filter_by_status') }}</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>{{ __('messages.status_new') }}</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('messages.status_in_progress') }}</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.status_completed') }}</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('messages.status_rejected') }}</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
            {{ __('messages.search') }}
        </button>
    </form>

    {{-- 📋 جدول الطلبات --}}
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-100 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                <tr>
                    <th class="px-4 py-3">{{ __('messages.status') }}</th>
                    <th class="px-4 py-3">{{ __('messages.id') }}</th>
                    <th class="px-4 py-3">{{ __('messages.building') }}</th>
                    <th class="px-4 py-3">{{ __('messages.unit') }}</th>
                    <th class="px-4 py-3">{{ __('messages.type') }}</th>
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
                            'awaiting_materials' => 'bg-purple-400',
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
                        <td class="px-4 py-2">{{ $request->type }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-2">
                            <a href="{{ route('admin.maintenance_requests.show', $request->id) }}" class="bg-gray-200 px-3 py-1 rounded text-xs">عرض</a>
                            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs">تعديل</a>
                            @if ($request->image)
                                <a href="{{ asset('storage/' . $request->image) }}" target="_blank" class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">صورة</a>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <form method="POST" action="{{ route('admin.maintenance_requests.update_status', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded">
                                    <option value="new" {{ $request->status == 'new' ? 'selected' : '' }}>{{ __('messages.status_new') }}</option>
                                    <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>{{ __('messages.status_in_progress') }}</option>
                                    <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>{{ __('messages.status_completed') }}</option>
                                    <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>{{ __('messages.status_rejected') }}</option>
                                    <option value="delayed" {{ $request->status == 'delayed' ? 'selected' : '' }}>{{ __('messages.status_delayed') }}</option>
                                    <option value="awaiting_materials" {{ $request->status == 'awaiting_materials' ? 'selected' : '' }}>{{ __('messages.status_awaiting_materials') }}</option>
                                    <option value="customer_unavailable" {{ $request->status == 'customer_unavailable' ? 'selected' : '' }}>{{ __('messages.status_customer_unavailable') }}</option>
                                    <option value="other" {{ $request->status == 'other' ? 'selected' : '' }}>{{ __('messages.status_other') }}</option>
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
