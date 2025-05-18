@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- 🛠️ عنوان الصفحة --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_maintenance_request') }}</h1>

    {{-- 📋 فورم التعديل --}}
    <form action="{{ route('admin.maintenance_requests.update', $request->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        {{-- المبنى --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.building') }}</label>
            <select name="building_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}" {{ $request->building_id == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الوحدة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.unit') }}</label>
            <select name="unit_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ $request->unit_id == $unit->id ? 'selected' : '' }}>
                        {{ $unit->unit_number }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- نوع العطل --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.category') }}</label>
            <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $request->category_id == $category->id ? 'selected' : '' }}>
                        {{ __('maintenance_categories.' . $category->slug) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- وصف المشكلة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.description') }}</label>
            <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ $request->description }}</textarea>
        </div>

        {{-- تعيين الفني --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.technician') }}</label>
            <select name="technician_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">{{ __('messages.select_technician') }}</option>
                @foreach($technicians as $technician)
                    <option value="{{ $technician->id }}" {{ $request->technician_id == $technician->id ? 'selected' : '' }}>
                        {{ $technician->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الحالة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.status') }}</label>
            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                @foreach(['new', 'in_progress', 'completed', 'rejected', 'delayed', 'waiting_materials', 'customer_unavailable', 'other'] as $status)
                    <option value="{{ $status }}" {{ $request->status == $status ? 'selected' : '' }}>
                        {{ __('messages.status_' . $status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ملاحظات البداية --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.start_notes') }}</label>
            <textarea name="start_notes" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ $request->start_notes }}</textarea>
        </div>

        {{-- ملاحظات النهاية --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.end_notes') }}</label>
            <textarea name="end_notes" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ $request->end_notes }}</textarea>
        </div>

        {{-- ملاحظات عامة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.note') }}</label>
            <textarea name="note" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">{{ $request->note }}</textarea>
        </div>

        {{-- التكلفة --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('messages.cost') }}</label>
            <input type="number" name="cost" step="0.01" value="{{ $request->cost }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
        </div>

        {{-- زر الحفظ --}}
        <div class="pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow text-sm font-semibold">
                {{ __('messages.save_changes') }}
            </button>
        </div>
    </form>

</div>
@endsection
