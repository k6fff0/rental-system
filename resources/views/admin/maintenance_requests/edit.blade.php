@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🛠️ عنوان الصفحة --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_maintenance_request') }}</h1>

    {{-- 📋 فورم التعديل --}}
    <form action="{{ route('admin.maintenance_requests.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        {{-- 🔒 عرض فقط - معلومات الطلب --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
                <input type="text" value="{{ $maintenance->building->name ?? '-' }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
                <input type="text" value="{{ $maintenance->unit->unit_number ?? '-' }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.sub_specialty') }}</label>
                <input type="text" value="{{ $maintenance->subSpecialty->parent->name ?? '---' }} → {{ $maintenance->subSpecialty->name ?? '-' }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.created_by') }}</label>
                <input type="text" value="{{ $maintenance->creator->name ?? '-' }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm">
            </div>
        </div>

        {{-- 📝 الملاحظات العامة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.description') }}</label>
            <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ $maintenance->description }}</textarea>
        </div>

        {{-- 👨‍🔧 تغيير الفني (اختياري) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.technician') }}</label>
            <select name="technician_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">{{ __('messages.select_technician') }}</option>
                @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}" {{ $maintenance->technician_id == $technician->id ? 'selected' : '' }}>
                        {{ $technician->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 🔁 تغيير الحالة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.status') }}</label>
            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                @foreach(['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                    <option value="{{ $status }}" {{ $maintenance->status == $status ? 'selected' : '' }}>
                        {{ __('messages.status_' . $status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 📸 صورة جديدة (بعد الإنجاز مثلاً) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.image') }}</label>
            @if($maintenance->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $maintenance->image) }}" class="h-32 w-auto rounded shadow border" alt="Image">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-700 border-gray-300 rounded-md shadow-sm">
        </div>

        {{-- 💸 التكلفة (اختياري) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.cost') }}</label>
            <input type="number" name="cost" step="0.01" value="{{ $maintenance->cost }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
        </div>

        {{-- 💾 زر الحفظ --}}
        <div class="pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow text-sm font-semibold">
                {{ __('messages.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
