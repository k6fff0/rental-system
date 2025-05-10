@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان + زر الإضافة --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.expense_list') }}</h1>
        <a href="{{ route('admin.expenses.create') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold shadow">
            + {{ __('messages.add_expense') }}
        </a>
    </div>

    {{-- الفلاتر --}}
    <form method="GET" action="{{ route('admin.expenses.index') }}"
          class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.building') }}</label>
            <select name="building_id" class="form-input w-full">
                <option value="">{{ __('messages.all') }}</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.type') }}</label>
            <select name="type" class="form-input w-full">
                <option value="">{{ __('messages.all') }}</option>
                <option value="furniture" {{ request('type') == 'furniture' ? 'selected' : '' }}>{{ __('messages.furniture') }}</option>
                <option value="painting" {{ request('type') == 'painting' ? 'selected' : '' }}>{{ __('messages.painting') }}</option>
                <option value="plumbing" {{ request('type') == 'plumbing' ? 'selected' : '' }}>{{ __('messages.plumbing') }}</option>
                <option value="electronics" {{ request('type') == 'electronics' ? 'selected' : '' }}>{{ __('messages.electronics') }}</option>
                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>{{ __('messages.other') }}</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.date') }}</label>
            <input type="date" name="expense_date" value="{{ request('expense_date') }}" class="form-input w-full">
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold shadow">
                {{ __('messages.filter') }}
            </button>
        </div>
    </form>

    {{-- عرض المصروفات --}}
    @if ($expenses->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_expenses') }}
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($expenses as $expense)
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between hover:shadow-lg transition-all border border-gray-200">
                    <div>
                        <h2 class="text-lg font-semibold text-blue-700 mb-2">
                            {{ __('messages.' . $expense->type) }}
                        </h2>

                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><strong>{{ __('messages.building') }}:</strong> {{ $expense->building->name ?? '-' }}</li>
                            <li><strong>{{ __('messages.unit') }}:</strong> {{ $expense->unit->unit_number ?? '-' }}</li>
                            <li><strong>{{ __('messages.amount') }}:</strong> {{ number_format($expense->amount, 2) }} {{ __('messages.currency') }}</li>
                            <li><strong>{{ __('messages.date') }}:</strong> {{ $expense->expense_date }}</li>
                            @if ($expense->description)
                                <li><strong>{{ __('messages.description') }}:</strong> {{ $expense->description }}</li>
                            @endif
                        </ul>
                    </div>

                    <div class="mt-4 flex justify-end gap-2">
                        <a href="{{ route('admin.expenses.edit', $expense->id) }}"
                           style="background-color: #2563eb; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px;">
                            {{ __('messages.edit') }}
                        </a>
                        <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                            style="background-color:rgb(235, 37, 37); color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px;">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
