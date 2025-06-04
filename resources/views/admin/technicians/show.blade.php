@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🧑‍🔧 عنوان --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.technician_profile') }}</h1>

    {{-- 🧾 بيانات الفني --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-6 text-sm text-gray-800">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <strong>{{ __('messages.name') }}:</strong>
                {{ $technician->name }}
            </div>
            <div>
                <strong>{{ __('messages.email') }}:</strong>
                {{ $technician->email }}
            </div>
            <div>
                <strong>{{ __('messages.phone') }}:</strong>
                {{ $technician->phone ?? '-' }}
            </div>
            <div>
                <strong>{{ __('messages.specialty') }}:</strong>
                {{ $technician->mainSpecialty->name ?? '-' }}
            </div>

            <div class="col-span-1 sm:col-span-2">
                <strong>المهام الإضافية:</strong>
                @php
                    $subTasks = $technician->mainSpecialty?->subSpecialties;
                @endphp

                @if ($subTasks && $subTasks->isNotEmpty())
                    <div class="mt-1 flex flex-wrap gap-2">
                        @foreach ($subTasks as $task)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $task->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-500">لا توجد مهام إضافية</span>
                @endif
            </div>

            <div>
                <strong>{{ __('messages.status') }}:</strong>
                @php
                    $colors = [
                        'available' => 'text-green-600',
                        'busy' => 'text-yellow-600',
                        'unavailable' => 'text-red-600',
                    ];
                    $status = $technician->technician_status ?? 'unavailable';
                @endphp
                <span class="font-semibold {{ $colors[$status] ?? '' }}">
                    {{ __('messages.status_' . $status) }}
                </span>
            </div>
        </div>

        @if($technician->notes)
            <div>
                <strong>{{ __('messages.notes') }}:</strong>
                <p class="mt-1 text-gray-700">{{ $technician->notes }}</p>
            </div>
        @endif

        {{-- زر الرجوع --}}
        <div class="pt-4">
            <a href="{{ route('admin.technicians.index') }}"
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded shadow text-sm">
                ← {{ __('messages.back_to_list') }}
            </a>
        </div>
    </div>

</div>
@endsection
