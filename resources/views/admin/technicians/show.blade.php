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
                {{ $technician->technicianProfile->specialty ?? '-' }}
            </div>
            <div>
                <strong>{{ __('messages.status') }}:</strong>
                @php
                    $colors = [
                        'available' => 'text-green-600',
                        'busy' => 'text-yellow-600',
                        'unavailable' => 'text-red-600',
                    ];
                    $status = $technician->technicianProfile->status ?? 'unavailable';
                @endphp
                <span class="font-semibold {{ $colors[$status] ?? '' }}">
                    {{ __('messages.status_' . $status) }}
                </span>
            </div>
        </div>

            @if($technician->technicianProfile && $technician->technicianProfile->notes)
              <div>
                   <strong>{{ __('messages.notes') }}:</strong>
                   <p class="mt-1 text-gray-700">{{ $technician->technicianProfile->notes }}</p>
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
