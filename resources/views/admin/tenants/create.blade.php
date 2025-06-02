@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.add_tenant') }}</h1>

        <form action="{{ route('admin.tenants.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf

            {{-- الاسم --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('messages.full_name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- الحالة --}}
            <div class="mb-4">
                <label for="tenant_status"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.tenant_status') }}</label>
                <select name="tenant_status" id="tenant_status" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option value="active" {{ old('tenant_status') == 'active' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_active') }}</option>
                    <option value="late_payer" {{ old('tenant_status') == 'late_payer' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_late_payer') }}</option>
                    <option value="has_debt" {{ old('tenant_status') == 'has_debt' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_has_debt') }}</option>
                    <option value="absent" {{ old('tenant_status') == 'absent' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_absent') }}</option>
                    <option value="abroad" {{ old('tenant_status') == 'abroad' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_abroad') }}</option>
                    <option value="legal_issue" {{ old('tenant_status') == 'legal_issue' ? 'selected' : '' }}>
                        {{ __('messages.tenant_status_legal_issue') }}</option>
                </select>
            </div>

            {{-- رقم الهوية --}}
            <div class="mb-4">
                <label for="id_number"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.id_number') }}</label>
                <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="family_type" class="block text-sm font-medium text-gray-700">نوع المستأجر</label>
                <select name="family_type" id="family_type" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="individual" {{ old('family_type') == 'individual' ? 'selected' : '' }}>فرد</option>
                    <option value="family" {{ old('family_type') == 'family' ? 'selected' : '' }}>عائلة</option>
                </select>
            </div>


            {{-- رقم الجوال --}}
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('messages.phone') }}</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- رقم إضافي --}}
            <div class="mb-4" x-data="{ showExtra: false }">
                <template x-if="showExtra">
                    <div>
                        <label for="secondary_phone"
                            class="block text-sm font-medium text-gray-700">{{ __('messages.secondary_phone') }}</label>
                        <input type="text" name="secondary_phone" id="secondary_phone"
                            value="{{ old('secondary_phone') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                    </div>
                </template>

                <button type="button" @click="showExtra = true" x-show="!showExtra"
                    class="mt-2 text-blue-600 hover:underline text-sm">
                    + {{ __('messages.add_another_phone') }}
                </button>
            </div>

            {{-- الإيميل --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('messages.email') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- الملاحظات --}}
            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('messages.notes') }}</label>
                <textarea name="notes" id="notes" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('notes') }}</textarea>
            </div>

            {{-- المديونية --}}
            <div class="mb-4">
                <label for="debt" class="block text-sm font-medium text-gray-700">{{ __('messages.debt') }}</label>
                <input type="number" name="debt" id="debt" step="0.01" min="0"
                    value="{{ old('debt', 0) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            {{-- الأزرار --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.tenants.index') }}"
                    class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-semibold">
                    {{ __('messages.back') }}
                </a>
                <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/css/intlTelInput.css" />
    <style>
        .iti {
            width: 100%;
        }

        .iti__flag-container {
            padding: 0 10px;
        }

        .iti__selected-flag {
            padding: 0 10px 0 15px;
        }

        /* الوضع الطبيعي (LTR) يكون الهنت ع اليمين والعلم على الشمال */
        [dir="ltr"] .iti--allow-dropdown input {
            text-align: right !important;
            padding-right: 60px !important;
            padding-left: 15px !important;
        }

        /* الوضع في العربي (RTL) الهنت شمال والعلم يمين */
        [dir="rtl"] .iti--allow-dropdown input {
            text-align: left !important;
            padding-left: 60px !important;
            padding-right: 15px !important;
        }
    </style>
@endpush


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector("#phone");

            if (input) {
                const iti = window.intlTelInput(input, {
                    initialCountry: "auto",
                    geoIpLookup: function(callback) {
                        fetch('https://ipapi.co/json/')
                            .then(res => res.json())
                            .then(data => callback(data.country_code))
                            .catch(() => callback("ae"));
                    },
                    preferredCountries: ["ae", "sa", "eg", "kw", "qa", "bh", "om"],
                    separateDialCode: true,
                    hiddenInput: "full_phone",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.1/js/utils.js"
                });

                // Handle form submission
                input.closest('form').addEventListener('submit', function(e) {
                    const phoneInput = document.querySelector("#phone");
                    if (phoneInput.value) {
                        phoneInput.value = iti.getNumber();
                    }
                });
            }
        });
    </script>
@endpush
