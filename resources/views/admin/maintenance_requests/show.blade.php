@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🧾 عنوان الصفحة --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.maintenance_request_details') }}</h1>

    {{-- 📄 تفاصيل البلاغ --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6 text-sm text-gray-800">

        {{-- 🧱 المعلومات العامة --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><strong>{{ __('messages.building') }}:</strong> {{ $request->building->name ?? '-' }}</div>
            <div><strong>{{ __('messages.unit') }}:</strong> {{ $request->unit->unit_number ?? '-' }}</div>
            <div><strong>{{ __('messages.category') }}:</strong> {{ __('maintenance_categories.' . ($request->category->slug ?? 'other')) }}</div>
            <div><strong>{{ __('messages.technician') }}:</strong> {{ $request->technician->name ?? __('messages.no_technician') }}</div>
            <div>
                <strong>{{ __('messages.status') }}:</strong>
                @php
                    $statusColors = [
                        'new' => 'bg-yellow-100 text-yellow-800',
                        'in_progress' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        'delayed' => 'bg-orange-100 text-orange-800',
                        'waiting_materials' => 'bg-purple-100 text-purple-800',
                        'customer_unavailable' => 'bg-pink-100 text-pink-800',
                        'other' => 'bg-gray-100 text-gray-800',
                    ];
                @endphp
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$request->status] ?? 'bg-gray-200 text-gray-800' }}">
                    {{ __('messages.status_' . $request->status) }}
                </span>
            </div>
            <div><strong>{{ __('messages.assigned_worker') }}:</strong> {{ $request->worker->name ?? '-' }}</div>
            <div><strong>{{ __('messages.cost') }}:</strong> {{ $request->cost ? $request->cost . ' ' . __('messages.currency') : '-' }}</div>
        </div>

        {{-- 📜 الوصف --}}
        <div>
            <strong>{{ __('messages.description') }}:</strong>
            <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $request->description }}</p>
        </div>

        {{-- 🖼️ صورة البلاغ --}}
        @if($request->image)
            <div>
                <strong>{{ __('messages.image') }}:</strong>
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $request->image) }}" alt="request image" class="max-w-xs rounded border shadow-sm">
                </div>
            </div>
        @endif

        {{-- 📝 ملاحظات --}}
        @if($request->start_notes)
            <div>
                <strong>{{ __('messages.start_notes') }}:</strong>
                <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $request->start_notes }}</p>
            </div>
        @endif

        @if($request->end_notes)
            <div>
                <strong>{{ __('messages.end_notes') }}:</strong>
                <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $request->end_notes }}</p>
            </div>
        @endif

        @if($request->note)
            <div>
                <strong>{{ __('messages.note') }}:</strong>
                <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $request->note }}</p>
            </div>
        @endif

        {{-- ✏️ زر التعديل --}}
        <div class="pt-4 text-end">
            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
               class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow text-sm hover:bg-blue-700 transition-all duration-200">
                {{ __('messages.edit') }}
            </a>
        </div>
    </div>

</div>
@endsection
