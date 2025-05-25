@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="rtl">

    {{-- العنوان --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">تفاصيل المبنى</h1>
        <a href="{{ route('admin.buildings.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← رجوع لقائمة المباني
        </a>
    </div>

    {{-- تفاصيل المبنى --}}
    <div class="bg-white p-6 rounded-lg shadow space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
            <div><strong>اسم المبنى:</strong> {{ $building->name }}</div>
            <div><strong>العنوان:</strong> {{ $building->address }}</div>

            {{-- رابط الموقع --}}
            @php
                $locationUrl = is_string($building->location_url) ? trim($building->location_url) : '';
            @endphp
            <div>
                <strong>رابط الموقع:</strong>
                @if (!empty($locationUrl) && filter_var($locationUrl, FILTER_VALIDATE_URL))
                    <a href="{{ $locationUrl }}" target="_blank" class="text-blue-600 hover:underline">عرض على الخريطة</a>
                @else
                    -
                @endif
            </div>

            <div><strong>اسم المالك:</strong> {{ $building->owner_name ?? '-' }}</div>
            <div><strong>الجنسية:</strong> {{ $building->owner_nationality ?? '-' }}</div>
            <div><strong>رقم الهوية:</strong> {{ $building->owner_id_number ?? '-' }}</div>
            <div><strong>رقم الموبايل:</strong> {{ $building->owner_phone ?? '-' }}</div>
            <div><strong>رقم تسجيل الوحدة في البلدية:</strong> {{ $building->municipality_number ?? '-' }}</div>
            <div><strong>سعر الإيجار الشهري:</strong> {{ $building->rent_amount ? number_format($building->rent_amount, 2) . ' درهم' : '-' }}</div>
            <div><strong>تكاليف التعديل لأول مرة:</strong> {{ $building->initial_renovation_cost ? number_format($building->initial_renovation_cost, 2) . ' درهم' : '-' }}</div>

            {{-- ✅ جديد --}}
            <div><strong>عدد الوحدات:</strong> {{ $building->units()->count() }}</div>
            <div><strong>تاريخ الإضافة:</strong> {{ $building->created_at?->format('Y-m-d') ?? '-' }}</div>
        </div>

        {{-- عدادات الكهرباء --}}
        <div>
            <strong class="block mb-2 text-sm text-gray-700">أرقام عدادات الكهرباء:</strong>
            @php
                $meters = is_array($building->electric_meters) ? $building->electric_meters : json_decode($building->electric_meters, true);
            @endphp
            @if (!empty($meters) && is_array($meters) && count($meters))
                <ul class="list-disc list-inside text-sm text-gray-600">
                    @foreach ($meters as $meter)
                        <li>{{ $meter }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500">لا يوجد عدادات.</p>
            @endif
        </div>

        {{-- خطوط الإنترنت --}}
        <div>
            <strong class="block mb-2 text-sm text-gray-700">خطوط الإنترنت:</strong>
            @php
                $internetLines = is_array($building->internet_lines) ? $building->internet_lines : json_decode($building->internet_lines, true);
            @endphp
            @if (!empty($internetLines) && is_array($internetLines) && count($internetLines))
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    @foreach ($internetLines as $line)
                        <li>
                            <span class="text-gray-700">الرقم:</span> {{ $line['line'] ?? '-' }} <br>
                            <span class="text-gray-700">المالك:</span> {{ $line['owner'] ?? '-' }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500">لا يوجد خطوط.</p>
            @endif
        </div>

        {{-- زر تعديل --}}
        <div class="text-left pt-4">
            <a href="{{ route('admin.buildings.edit', $building->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow transition">
                تعديل بيانات المبنى
            </a>
        </div>
    </div>
</div>
@endsection
