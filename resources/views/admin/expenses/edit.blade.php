@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        {{-- العنوان --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.edit_expense') }}</h1>
            <a href="{{ route('admin.expenses.index') }}" class="text-sm text-blue-600 hover:underline">
                ← {{ __('messages.back_to_expenses') }}
            </a>
        </div>

        {{-- النموذج --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- شبكة الحقول --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div>
                        <label for="type" class="block mb-1 text-sm font-medium">{{ __('messages.type') }} *</label>
                        <select name="type" id="type" class="form-input w-full" required>
                            <option value="furniture" {{ $expense->type === 'furniture' ? 'selected' : '' }}>
                                {{ __('messages.furniture') }}</option>
                            <option value="painting" {{ $expense->type === 'painting' ? 'selected' : '' }}>
                                {{ __('messages.painting') }}</option>
                            <option value="plumbing" {{ $expense->type === 'plumbing' ? 'selected' : '' }}>
                                {{ __('messages.plumbing') }}</option>
                            <option value="electronics" {{ $expense->type === 'electronics' ? 'selected' : '' }}>
                                {{ __('messages.electronics') }}</option>
                            <option value="other" {{ $expense->type === 'other' ? 'selected' : '' }}>
                                {{ __('messages.other') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="building_id" class="block mb-1 text-sm font-medium">{{ __('messages.building') }}
                            *</label>
                        <select name="building_id" id="building_id" class="form-input w-full" required>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}"
                                    {{ $expense->building_id == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="unit_id" class="block mb-1 text-sm font-medium">{{ __('messages.unit') }}</label>
                        <select name="unit_id" id="unit_id" class="form-input w-full">
                            <option value="">{{ __('messages.select_unit_optional') }}</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ $expense->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="amount" class="block mb-1 text-sm font-medium">{{ __('messages.amount') }} *</label>
                        <input type="number" name="amount" id="amount" class="form-input w-full" step="0.01"
                            required value="{{ $expense->amount }}">
                    </div>

                    <div>
                        <label for="expense_date" class="block mb-1 text-sm font-medium">{{ __('messages.date') }}
                            *</label>
                        <input type="date" name="expense_date" id="expense_date" class="form-input w-full" required
                            value="{{ $expense->expense_date }}">
                    </div>

                    <div>
                        <label for="invoice_images[]"
                            class="block mb-1 text-sm font-medium">{{ __('messages.add_new_invoice') }}</label>
                        <input type="file" name="invoice_images[]" id="invoice_images" accept="image/*"
                            class="form-input w-full" multiple>
                    </div>
                </div>

                {{-- عرض صور الفواتير الحالية --}}
                @if ($expense->images && $expense->images->count())
                    <div class="mt-8">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">{{ __('messages.current_invoices') }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($expense->images as $image)
                                <div class="bg-gray-50 p-3 rounded shadow border flex flex-col items-center">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Invoice Image"
                                        class="w-full h-auto max-h-48 object-contain rounded">
                                    <a href="{{ asset('storage/' . $image->image_path) }}"
                                        onclick="window.open(this.href, '_blank', 'width=800,height=600'); return false;"
                                        style="background-color: #2563EB; color: white;"
                                        class="mt-3 px-4 py-1 text-sm font-medium rounded shadow hover:opacity-90 transition">
                                        {{ __('messages.view_invoice') }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- الوصف --}}
                <div class="mt-6">
                    <label for="description"
                        class="block mb-1 text-sm font-medium">{{ __('messages.description') }}</label>
                    <textarea name="description" id="description" rows="3" class="form-input w-full">{{ $expense->description }}</textarea>
                </div>

                {{-- الأزرار --}}
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <button type="submit" style="background-color: #16A34A; color: white;"
                        class="px-4 py-2 text-sm font-medium rounded-md shadow transition whitespace-nowrap">
                        {{ __('messages.update_expense') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
