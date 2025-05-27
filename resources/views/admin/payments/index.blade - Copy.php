@extends('layouts.app')

@section('title', __('messages.payments_list'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Enhanced Header Section --}}
        <div class="mb-10">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 backdrop-blur-sm">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    {{-- Title Section --}}
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse mb-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                <span class="text-white text-2xl">💰</span>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 bg-clip-text text-transparent">
                                    {{ __('messages.payments_list') }}
                                </h1>
                                <p class="text-gray-600 text-lg mt-1">
                                    {{ __('messages.manage_payments_description') ?? 'Manage and track all rental payments' }}
                                </p>
                            </div>
                        </div>
                        
                        {{-- Stats Cards --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-4 text-white shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">{{ __('messages.total_payments') ?? 'Total Payments' }}</p>
                                        <p class="text-2xl font-bold">{{ $payments->total() ?? $payments->count() }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-400 bg-opacity-30 rounded-xl flex items-center justify-center">
                                        <span class="text-xl">📊</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-4 text-white shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100 text-sm font-medium">{{ __('messages.this_month') ?? 'This Month' }}</p>
                                        <p class="text-2xl font-bold">{{ $payments->where('payment_date', '>=', now()->startOfMonth())->count() ?? '0' }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-green-400 bg-opacity-30 rounded-xl flex items-center justify-center">
                                        <span class="text-xl">📅</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-4 text-white shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-purple-100 text-sm font-medium">{{ __('messages.total_amount') ?? 'Total Amount' }}</p>
                                        <p class="text-2xl font-bold">{{ number_format($payments->sum('amount') ?? 0, 0) }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-purple-400 bg-opacity-30 rounded-xl flex items-center justify-center">
                                        <span class="text-xl">💎</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.payments.due_report') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">📊</span>
                            {{ __('messages.monthly_due_report') }}
                        </a>
                        
                        <a href="{{ route('admin.payments.create') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <span class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }} font-bold">+</span>
                            {{ __('messages.add_payment') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Enhanced Payments Table --}}
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
            {{-- Table Header --}}
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-8 py-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <span class="w-3 h-8 bg-gradient-to-b from-green-400 to-green-600 rounded-full {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}"></span>
                        {{ __('messages.payments_table') ?? 'Payments Records' }}
                    </h2>
                    <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-xl">
                        {{ __('messages.total_records') ?? 'Total' }}: <span class="font-bold text-gray-800">{{ $payments->total() ?? $payments->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Responsive Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-green-400">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                    <span>{{ __('messages.contract') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-purple-400 hidden md:table-cell">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                                    <span>{{ __('messages.tenant') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-green-400">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                    <span>{{ __('messages.amount') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-blue-400 hidden lg:table-cell">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                    <span>{{ __('messages.payment_date') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-orange-400 hidden lg:table-cell">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="w-2 h-2 bg-orange-400 rounded-full"></span>
                                    <span>{{ __('messages.month_for') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-indigo-400 hidden xl:table-cell">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="w-2 h-2 bg-indigo-400 rounded-full"></span>
                                    <span>{{ __('messages.payment_method') }}</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-yellow-400 hidden xl:table-cell">
							
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                <span>{{ __('messages.collected_by') }}</span>
            </div>
        </th>
        <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-600 uppercase tracking-wider border-b-3 border-pink-400 hidden xl:table-cell">
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <span class="w-2 h-2 bg-pink-400 rounded-full"></span>
                <span>{{ __('messages.notes') }}</span>
            </div>
        </th>
    </tr>
</thead>
<tbody class="bg-white divide-y divide-gray-100">

                        @forelse($payments as $payment)
						<td class="px-6 py-6 whitespace-nowrap hidden xl:table-cell">
    <div class="flex items-center">
        @if($payment->collector)
            <div class="w-8 h-8 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">
                <span class="text-yellow-700 text-xs">👤</span>
            </div>
            <span class="text-sm font-medium text-gray-900">{{ $payment->collector->name }}</span>
        @else
            <span class="text-gray-400 italic text-sm">-</span>
        @endif
    </div>
</td>
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 group">
                                {{-- Contract Number --}}
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }} group-hover:shadow-lg transition-shadow duration-300">
                                            <span class="text-blue-700 font-bold text-sm">📄</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">
                                                {{ $payment->contract->contract_number }}
                                            </div>
                                            {{-- Mobile: Show tenant name here --}}
                                            <div class="md:hidden mt-1">
                                                <span class="text-xs text-gray-600 bg-purple-50 px-2 py-1 rounded-lg border border-purple-200">
                                                    👤 {{ $payment->contract->tenant->name ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tenant Name (Hidden on mobile) --}}
                                <td class="px-6 py-6 whitespace-nowrap hidden md:table-cell">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">
                                            <span class="text-purple-700 text-xs">👤</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $payment->contract->tenant->name ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Amount --}}
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-lg font-bold text-green-700 bg-green-50 px-3 py-2 rounded-xl border-2 border-green-200 shadow-sm">
                                            {{ number_format($payment->amount, 2) }}
                                            <span class="text-xs text-green-600 ml-1">{{ __('messages.currency') ?? 'AED' }}</span>
                                        </div>
                                    </div>
                                    {{-- Mobile: Show additional info --}}
                                    <div class="lg:hidden mt-2 space-y-1">
                                        <div class="text-xs text-gray-600 bg-blue-50 px-2 py-1 rounded-lg inline-block">
                                            📅 {{ $payment->payment_date }}
                                        </div>
                                        <div class="text-xs text-gray-600 bg-orange-50 px-2 py-1 rounded-lg inline-block {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">
                                            🗓️ {{ \Carbon\Carbon::parse($payment->month_for)->translatedFormat('F Y') }}
                                        </div>
                                    </div>
                                </td>

                                {{-- Payment Date (Hidden on mobile/tablet) --}}
                                <td class="px-6 py-6 whitespace-nowrap hidden lg:table-cell">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">
                                            <span class="text-blue-700 text-xs">📅</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $payment->payment_date }}</span>
                                    </div>
                                </td>

                                {{-- Month For (Hidden on mobile/tablet) --}}
                                <td class="px-6 py-6 whitespace-nowrap hidden lg:table-cell">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">
                                            <span class="text-orange-700 text-xs">🗓️</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 bg-orange-50 px-3 py-1 rounded-lg border border-orange-200">
                                            {{ \Carbon\Carbon::parse($payment->month_for)->translatedFormat('F Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Payment Method (Hidden on mobile/tablet) --}}
                                <td class="px-6 py-6 whitespace-nowrap hidden xl:table-cell">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                            @if($payment->method === 'cash') bg-green-100 text-green-800 border border-green-200
                                            @elseif($payment->method === 'bank_transfer') bg-blue-100 text-blue-800 border border-blue-200
                                            @elseif($payment->method === 'check') bg-purple-100 text-purple-800 border border-purple-200
                                            @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                            @if($payment->method === 'cash') 💵
                                            @elseif($payment->method === 'bank_transfer') 🏦
                                            @elseif($payment->method === 'check') 🏧
                                            @else 💳 @endif
                                            <span class="{{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">
                                                {{ __('messages.' . $payment->method) }}
                                            </span>
                                        </span>
                                    </div>
                                </td>

                                {{-- Notes (Hidden on mobile/tablet) --}}
                                <td class="px-6 py-6 hidden xl:table-cell">
                                    <div class="max-w-xs">
                                        @if($payment->notes)
                                            <div class="text-sm text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-200 truncate" title="{{ $payment->notes }}">
                                                📝 {{ $payment->notes }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-sm">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mb-6 shadow-lg">
                                            <span class="text-gray-400 text-4xl">💰</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('messages.no_payments_found') }}</h3>
                                        <p class="text-gray-500 text-sm mb-6">{{ __('messages.no_payments_description') ?? 'No payment records available at the moment.' }}</p>
                                        <a href="{{ route('admin.payments.create') }}" 
                                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                                            <span class="text-lg {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}">+</span>
                                            {{ __('messages.create_first_payment') ?? 'Create First Payment' }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Enhanced Pagination --}}
            @if(method_exists($payments, 'hasPages') && $payments->hasPages())
                <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700 order-2 sm:order-1">
                            <span class="font-medium">{{ __('messages.showing') ?? 'Showing' }}</span>
                            <span class="font-bold text-blue-600">{{ $payments->firstItem() }}</span>
                            {{ __('messages.to') ?? 'to' }}
                            <span class="font-bold text-blue-600">{{ $payments->lastItem() }}</span>
                            {{ __('messages.of') ?? 'of' }}
                            <span class="font-bold text-blue-600">{{ $payments->total() }}</span>
                            <span class="font-medium">{{ __('messages.results') ?? 'results' }}</span>
                        </div>
                        <div class="pagination-wrapper order-1 sm:order-2">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Enhanced Custom Styles --}}
<style>
/* Advanced Pagination Styling */
.pagination-wrapper .pagination {
    @apply flex items-center space-x-1 rtl:space-x-reverse;
}

.pagination-wrapper .page-link {
    @apply px-4 py-2 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-700 hover:border-blue-300 transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5;
}

.pagination-wrapper .page-item.active .page-link {
    @apply bg-gradient-to-r from-blue-600 to-blue-700 text-white border-blue-600 shadow-lg transform translate-y-0;
}

.pagination-wrapper .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed hover:bg-white hover:text-gray-400 hover:border-gray-200 hover:transform-none hover:shadow-sm;
}

/* Mobile Responsive Improvements */
@media (max-width: 768px) {
    .max-w-7xl {
        @apply px-2;
    }
    
    table th, table td {
        @apply px-4 py-4;
    }
    
    .pagination-wrapper {
        @apply overflow-x-auto pb-2;
    }
    
    .pagination-wrapper .pagination {
        @apply flex-nowrap min-w-max;
    }
}

/* RTL Support */
[dir="rtl"] .pagination-wrapper .pagination {
    @apply space-x-reverse;
}

[dir="rtl"] .transform.rotate-3 {
    @apply -rotate-3;
}

/* Advanced Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(3deg); }
    50% { transform: translateY(-5px) rotate(0deg); }
}

.hover\:animate-float:hover {
    animation: float 2s ease-in-out infinite;
}

@keyframes pulse-soft {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.animate-pulse-soft {
    animation: pulse-soft 2s ease-in-out infinite;
}

/* Gradient Text Animation */
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-animated {
    background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
    background-size: 400% 400%;
    animation: gradient-shift 4s ease infinite;
}

/* Custom Scrollbar */
.overflow-x-auto::-webkit-scrollbar {
    height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: linear-gradient(to right, #3b82f6, #1d4ed8);
    border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to right, #1d4ed8, #1e40af);
}
</style>
@endsection