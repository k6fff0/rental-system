@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.add_expense') }}</h1>
        <a href="{{ route('admin.expenses.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← {{ __('messages.back_to_expenses') }}
        </a>
    </div>

    {{-- النموذج --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- شبكة الحقول --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div>
                    <label for="type" class="block mb-1 text-sm font-medium">{{ __('messages.type') }} *</label>
                    <select name="type" id="type" class="form-input w-full" required>
                        <option value="furniture">{{ __('messages.furniture') }}</option>
                        <option value="painting">{{ __('messages.painting') }}</option>
                        <option value="plumbing">{{ __('messages.plumbing') }}</option>
                        <option value="electronics">{{ __('messages.electronics') }}</option>
                        <option value="other">{{ __('messages.other') }}</option>
                    </select>
                </div>

                <div>
                    <label for="building_id" class="block mb-1 text-sm font-medium">{{ __('messages.building') }} *</label>
                    <select name="building_id" id="building_id" class="form-input w-full" required>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}">{{ $building->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="unit_id" class="block mb-1 text-sm font-medium">{{ __('messages.unit') }}</label>
                    <select name="unit_id" id="unit_id" class="form-input w-full">
                        <option value="">{{ __('messages.select_unit_optional') }}</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unit_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="amount" class="block mb-1 text-sm font-medium">{{ __('messages.amount') }} *</label>
                    <input type="number" name="amount" id="amount" class="form-input w-full" step="0.01" required>
                </div>

                <div>
                    <label for="expense_date" class="block mb-1 text-sm font-medium">{{ __('messages.date') }} *</label>
                    <input type="date" name="expense_date" id="expense_date" class="form-input w-full" required>
                </div>

                <div>
                    <label for="invoice_image" class="block mb-1 text-sm font-medium">{{ __('messages.invoice_image') }}</label>
                    <input type="file" name="invoice_image" id="invoice_image" accept="image/*" class="form-input w-full">
                </div>
            </div>

            {{-- الوصف --}}
            <div class="mt-6">
                <label for="description" class="block mb-1 text-sm font-medium">{{ __('messages.description') }}</label>
                <textarea name="description" id="description" rows="3" class="form-input w-full"></textarea>
            </div>

            {{-- زر الحفظ --}}
            <div class="mt-8 text-left">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md shadow transition">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
