@extends('layouts.app')

@section('title', __('messages.add_payment'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-0 via-blue-20 to-indigo-20">
        <div class="max-w-5xl mx-auto py-1 px-1 sm:px-2 lg:px-2" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <!-- Cash Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-green-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>

                    <!-- Title -->
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-green-800">
                        {{ __('messages.add_payment') }}
                    </span>
                </h1>

                <!-- Underline -->
                <div class="mt-2 h-1 w-20 bg-gradient-to-r from-green-400 to-green-200 rounded-full"></div>
            </div>

            <!-- Main Card Container -->
            <div class="relative">
                <!-- Glassmorphism Effect -->
                <div class="absolute inset-0 bg-white/70 backdrop-blur-xl rounded-3xl"></div>
                <div
                    class="relative bg-white/20 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 overflow-hidden">

                    <!-- Animated Top Border -->
                    <div class="h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 animate-gradient-x"></div>

                    <!-- Card Body -->
                    <div class="p-4 lg:p-10">
                        <form action="{{ route('admin.payments.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Contract Selection - Featured -->
                            <div class="relative group">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-300">
                                </div>
                                <div class="relative bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                                    <label for="contract_id"
                                        class="flex items-center text-base font-semibold text-gray-600 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 mr-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('messages.contract') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select id="contract_id" name="contract_id" required
                                        class="select2 block w-full rounded-xl border-1 border-gray-200 bg-white/80 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 focus:bg-white transition-all duration-300 text-center placeholder:text-gray-400">
                                        <option value="">{{ __('messages.select_contract') }}</option>
                                        @foreach ($contracts as $contract)
                                            <option value="{{ $contract->id }}" class="text-left">
                                                [{{ $contract->contract_number }}] {{ $contract->tenant->name ?? '---' }} -
                                                {{ __('messages.unit') }} {{ $contract->unit->unit_number ?? '—' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Form Fields Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-1">
                                <!-- Amount -->
                                <div class="group">
                                    <label for="amount"
                                        class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('messages.amount') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                            <span
                                                class="text-emerald-600 font-bold text-lg">{{ config('settings.currency_symbol') }}</span>
                                        </div>
                                        <input type="number" step="0.01" name="amount" id="amount" required
                                            class="block w-full rounded-xl border-2 border-gray-200 {{ app()->getLocale() === 'ar' ? 'pr-12' : 'pl-12' }} py-2 bg-white/80 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 focus:bg-white transition-all duration-300 text-lg font-medium hover:shadow-md">
                                    </div>
                                </div>

                                <!-- Payment Date -->
                                <div class="group">
                                    <label for="payment_date"
                                        class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('messages.payment_date') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="date" name="payment_date" id="payment_date" required
                                        value="{{ now()->toDateString() }}"
                                        class="block w-full rounded-xl border-2 border-gray-200 py-2 bg-white/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:bg-white transition-all duration-300 hover:shadow-md">
                                </div>

                                <!-- Month For -->
                                <div class="group">
                                    <label for="month_for"
                                        class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('messages.month_for') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="month" name="month_for" id="month_for" required
                                        value="{{ now()->format('Y-m') }}"
                                        class="block w-full rounded-xl border-2 border-gray-200 py-2 bg-white/80 focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 focus:bg-white transition-all duration-300 hover:shadow-md">
                                </div>

                                <!-- Payment Method -->
                                <div class="group">
                                    <label for="method"
                                        class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                        {{ __('messages.payment_method') }}
                                    </label>
                                    <select name="method" id="method"
                                        class="block w-full rounded-xl border-2 border-gray-200 py-2 bg-white/80 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 focus:bg-white transition-all duration-300 hover:shadow-md">
                                        <option value="cash">💵 {{ __('messages.cash') }}</option>
                                        <option value="bank">🏦 {{ __('messages.bank_transfer') }}</option>
                                        <option value="cheque">📄 {{ __('messages.cheque') }}</option>
                                        <option value="other">🔄 {{ __('messages.other') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            <div class="group">
                                <label for="notes" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                                    <div class="w-2 h-2 bg-teal-500 rounded-full mr-2 group-focus-within:animate-ping">
                                    </div>
                                    {{ __('messages.notes') }}
                                </label>
                                <textarea name="notes" id="notes" rows="2" placeholder="أضف أي ملاحظات إضافية هنا..."
                                    class="block w-full rounded-xl border-2 border-gray-200 py-4 px-4 bg-white/80 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/20 focus:bg-white transition-all duration-300 hover:shadow-md resize-none"></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 rtl:space-x-reverse pt-8">
                                <button type="submit"
                                    class="group relative inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-lg text-base font-medium text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/50 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 mr-2 group-hover:rotate-12 transition-transform duration-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('messages.save_payment') }}
                                    <div
                                        class="absolute inset-0 rounded-xl bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </button>
                                <a href="{{ route('admin.payments.index') }}"
                                    class="group relative inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 rounded-xl text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-500/20 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    {{ __('messages.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Gradient Animation */
        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 3s ease infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        /* Select2 Enhanced Styling */
        .select2-container--default .select2-selection--single {
            height: 56px !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            padding: 0 1rem !important;
            background: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease !important;
        }

        .select2-container--default .select2-selection--single:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 52px !important;
            right: 1rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 52px !important;
            padding: 0 !important;
            text-align: center !important;
            font-size: 1rem !important;
            color: #6b7280 !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2) !important;
            background: white !important;
        }

        .select2-dropdown {
            border: 2px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            overflow: hidden !important;
        }

        .select2-results__option {
            padding: 1rem !important;
            transition: all 0.2s ease !important;
        }

        .select2-results__option--highlighted {
            background: linear-gradient(135deg, #10b981, #14b8a6) !important;
            color: white !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #10b981, #14b8a6);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #059669, #0d9488);
        }

        /* Floating Label Effect */
        .group:focus-within label {
            color: #10b981;
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
@endpush

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                width: '100%',
                placeholder: "{{ __('messages.select_contract') }}",
                dir: "{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}",
                dropdownAutoWidth: true,
                dropdownParent: $('.select2').parent(),
                minimumResultsForSearch: 5
            });

            // Add loading animation to form submission
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html(`
                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    جاري الحفظ...
                `);
            });

            // Add ripple effect to buttons
            $('.group button, .group a').on('click', function(e) {
                const ripple = $(
                    '<div class="absolute rounded-full bg-white opacity-50 pointer-events-none"></div>');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.css({
                    width: size,
                    height: size,
                    left: x,
                    top: y,
                    transform: 'scale(0)',
                    animation: 'ripple 0.6s linear'
                });

                $(this).append(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.append(style);
    </script>
@endpush
