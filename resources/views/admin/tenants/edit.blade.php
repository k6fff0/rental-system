@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.edit_tenant') }}</h1>

        <form action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf
            @method('PUT')

            {{-- الاسم --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.full_name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- الحالة --}}
            <div class="mb-4">
                <label for="tenant_status"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.tenant_status') }}</label>
                <select name="tenant_status" id="tenant_status" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option value="active" {{ old('tenant_status', $tenant->tenant_status) == 'active' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_active') }}</option>
                    <option value="late_payer"
                        {{ old('tenant_status', $tenant->tenant_status) == 'late_payer' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_late_payer') }}</option>
                    <option value="has_debt"
                        {{ old('tenant_status', $tenant->tenant_status) == 'has_debt' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_has_debt') }}</option>
                    <option value="absent"
                        {{ old('tenant_status', $tenant->tenant_status) == 'absent' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_absent') }}</option>
                    <option value="abroad"
                        {{ old('tenant_status', $tenant->tenant_status) == 'abroad' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_abroad') }}</option>
                    <option value="legal_issue"
                        {{ old('tenant_status', $tenant->tenant_status) == 'legal_issue' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_legal_issue') }}</option>
                </select>
            </div>

            {{-- المديونية --}}
            <div class="mb-4">
                <label for="debt" class="block text-sm font-medium text-gray-700">{{ __('messages.debt') }}</label>
                <input type="number" name="debt" id="debt" min="0" step="0.01"
                    value="{{ old('debt', $tenant->debt) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- رقم الهوية --}}
            <div class="mb-4">
                <label for="id_number"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.id_number') }}</label>
                <input type="text" name="id_number" id="id_number" value="{{ old('id_number', $tenant->id_number) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            {{-- نوع المستأجر --}}
            <div class="mb-4">
                <label for="family_type" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.family_type') }}
                </label>
                <select name="family_type" id="family_type"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="individual" {{ $tenant->family_type === 'individual' ? 'selected' : '' }}>
                        {{ __('messages.individual') }}
                    </option>
                    <option value="family" {{ $tenant->family_type === 'family' ? 'selected' : '' }}>
                        {{ __('messages.family') }}
                    </option>
                </select>
            </div>

            {{-- الجوال --}}
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('messages.phone') }}</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $tenant->phone) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- الإيميل --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email', $tenant->email) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- ملاحظات --}}
            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
                <textarea name="notes" id="notes" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes', $tenant->notes) }}</textarea>
            </div>

            {{-- الأزرار --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.tenants.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                    {{ __('messages.back') }}
                </a>
                <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                    {{ __('messages.update') }}
                </button>
            </div>
        </form>
    </div>
@endsection
