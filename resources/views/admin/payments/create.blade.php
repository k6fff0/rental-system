@extends('layouts.app')

@section('title', __('messages.add_payment'))

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V9m10 0H6" />
</svg>

            {{ __('messages.add_payment') }}
        </h1>
    </div>

    <form action="{{ route('admin.payments.store') }}" method="POST">
        @csrf

        {{-- 🔗 اختيار العقد --}}
        <div class="mb-4">
            <label for="contract_id" class="block font-medium text-sm text-gray-700">{{ __('messages.contract') }}</label>
            <select id="contract_id" name="contract_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">{{ __('messages.select_contract') }}</option>
                @foreach($contracts as $contract)
                    <option value="{{ $contract->id }}">
                        {{ $contract->code }} - {{ $contract->tenant->name ?? '---' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 💵 المبلغ --}}
        <div class="mb-4">
            <label for="amount" class="block font-medium text-sm text-gray-700">{{ __('messages.amount') }}</label>
            <input type="number" step="0.01" name="amount" id="amount" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        {{-- 📅 تاريخ الدفع --}}
        <div class="mb-4">
            <label for="payment_date" class="block font-medium text-sm text-gray-700">{{ __('messages.payment_date') }}</label>
            <input type="date" name="payment_date" id="payment_date" required
                   value="{{ now()->toDateString() }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        {{-- 📆 الشهر الخاص بالدفع --}}
        <div class="mb-4">
            <label for="month_for" class="block font-medium text-sm text-gray-700">{{ __('messages.month_for') }}</label>
            <input type="month" name="month_for" id="month_for" required
                   value="{{ now()->format('Y-m') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        {{-- 💳 طريقة الدفع --}}
        <div class="mb-4">
            <label for="method" class="block font-medium text-sm text-gray-700">{{ __('messages.payment_method') }}</label>
            <select name="method" id="method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="cash">{{ __('messages.cash') }}</option>
                <option value="bank">{{ __('messages.bank_transfer') }}</option>
                <option value="cheque">{{ __('messages.cheque') }}</option>
                <option value="other">{{ __('messages.other') }}</option>
            </select>
        </div>

        {{-- 📝 ملاحظات --}}
        <div class="mb-4">
            <label for="notes" class="block font-medium text-sm text-gray-700">{{ __('messages.notes') }}</label>
            <textarea name="notes" id="notes" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
        </div>

        {{-- زر الحفظ --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 shadow">
                {{ __('messages.save_payment') }}
            </button>
        </div>
    </form>
</div>
@endsection
