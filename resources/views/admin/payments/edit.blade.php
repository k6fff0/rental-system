@extends('layouts.app')

@section('title', __('messages.edit_payment'))

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h1 class="text-2xl font-bold mb-6">{{ __('messages.edit_payment') }}</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}">
        @csrf
        @method('PUT')

        {{-- ✅ اختيار العقد --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">{{ __('messages.contract') }}</label>
            <select name="contract_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
                @foreach ($contracts as $contract)
                    <option value="{{ $contract->id }}"
                        {{ old('contract_id', $payment->contract_id) == $contract->id ? 'selected' : '' }}>
                        {{ $contract->contract_number }} - {{ $contract->tenant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- تاريخ الدفع --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">{{ __('messages.payment_date') }}</label>
            <input type="date" name="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        {{-- الشهر --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">{{ __('messages.month_for') }}</label>
            <input type="month" name="month_for" value="{{ old('month_for', \Carbon\Carbon::parse($payment->month_for)->format('Y-m')) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        {{-- المبلغ --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">{{ __('messages.amount') }}</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        {{-- وسيلة الدفع --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">{{ __('messages.method') }}</label>
            <input type="text" name="method" value="{{ old('method', $payment->method) }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        {{-- الملاحظات --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">{{ __('messages.notes') }}</label>
            <textarea name="notes" rows="3"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200">{{ old('notes', $payment->notes) }}</textarea>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.payments.index') }}"
               class="text-gray-600 hover:text-gray-800">{{ __('messages.back') }}</a>

            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                {{ __('messages.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
