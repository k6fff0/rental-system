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

            <div>
                <strong>رابط الموقع:</strong>
                @if ($building->location_url)
                    <a href="{{ $building->location_url }}" target="_blank" class="text-blue-600 hover:underline">عرض على الخريطة</a>
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
        </div>

        {{-- عدادات الكهرباء --}}
        <div>
            <strong class="block mb-2 text-sm text-gray-700">أرقام عدادات الكهرباء:</strong>
            @if (!empty($building->electric_meters) && count($building->electric_meters))
                <ul class="list-disc list-inside text-sm text-gray-600">
                    @foreach ($building->electric_meters as $meter)
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
            @if (!empty($building->internet_lines) && count($building->internet_lines))
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    @foreach ($building->internet_lines as $line)
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
