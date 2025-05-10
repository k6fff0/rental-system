@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🧾 عنوان الصفحة --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.maintenance_request_details') }}</h1>

    {{-- 📄 تفاصيل البلاغ --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-4 text-sm text-gray-800">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><strong>{{ __('messages.building') }}:</strong> {{ $request->building->name ?? '-' }}</div>
            <div><strong>{{ __('messages.unit') }}:</strong> {{ $request->unit->name ?? '-' }}</div>
            <div><strong>{{ __('messages.type') }}:</strong> {{ $request->type }}</div>
            <div>
                <strong>{{ __('messages.status') }}:</strong>
                @php
                    $statusClasses = [
                        'new' => 'bg-yellow-200',
                        'in_progress' => 'bg-blue-200',
                        'completed' => 'bg-green-200',
                        'rejected' => 'bg-red-200',
                    ];
                @endphp
                <span class="px-2 py-1 rounded text-xs {{ $statusClasses[$request->status] ?? '' }}">
                    {{ __('messages.status_' . $request->status) }}
                </span>
            </div>
            <div><strong>{{ __('messages.assigned_worker') }}:</strong> {{ $request->worker->name ?? '-' }}</div>
            <div><strong>{{ __('messages.cost') }}:</strong> {{ $request->cost ? $request->cost . ' ' . __('messages.currency') : '-' }}</div>
        </div>

        <div>
            <strong>{{ __('messages.description') }}:</strong>
            <p class="mt-1 text-gray-700">{{ $request->description }}</p>
        </div>

        @if($request->image)
            <div>
                <strong>{{ __('messages.image') }}:</strong>
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $request->image) }}" alt="request image" class="max-w-xs rounded border">
                </div>
            </div>
        @endif

        @if($request->start_notes)
            <div>
                <strong>{{ __('messages.start_notes') }}:</strong>
                <p class="mt-1 text-gray-700">{{ $request->start_notes }}</p>
            </div>
        @endif

        @if($request->end_notes)
            <div>
                <strong>{{ __('messages.end_notes') }}:</strong>
                <p class="mt-1 text-gray-700">{{ $request->end_notes }}</p>
            </div>
        @endif

        @if($request->note)
            <div>
                <strong>{{ __('messages.note') }}:</strong>
                <p class="mt-1 text-gray-700">{{ $request->note }}</p>
            </div>
        @endif

        <div class="pt-4">
            <a href="{{ route('admin.maintenance_requests.edit', $request->id) }}"
               class="inline-block bg-blue-600 text-white px-4 py-2 rounded shadow text-sm">
                {{ __('messages.edit') }}
            </a>
        </div>
    </div>

</div>
@endsection
