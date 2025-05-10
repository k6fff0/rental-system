@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- العنوان والتنبيهات -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                {{ __('messages.admin_dashboard') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('messages.welcome_back') }}, {{ Auth::user()->name }}</p>
        </div>
        
        <!-- تنبيهات سريعة -->
        @if($expiringContracts->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium">{{ __('messages.expiring_contracts_alert', ['count' => $expiringContracts->count()]) }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- بطاقات الإحصاءات -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- المستخدمين -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">{{ __('messages.users') }}</h2>
                    <p class="text-3xl font-bold mt-2">{{ $usersCount }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <a href="{{ route('admin.users.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                {{ __('messages.view_all') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- المباني -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">{{ __('messages.buildings') }}</h2>
                    <p class="text-3xl font-bold mt-2">{{ $buildingsCount }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <a href="{{ route('admin.buildings.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                {{ __('messages.view_all') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- الوحدات -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">{{ __('messages.units') }}</h2>
                    <p class="text-3xl font-bold mt-2">{{ $unitsCount }}</p>
                    <div class="flex space-x-2 mt-1 text-xs">
                        <span class="text-green-600">{{ $availableUnitsCount }} {{ __('messages.available') }}</span>
                        <span class="text-red-600">{{ $occupiedUnitsCount }} {{ __('messages.occupied') }}</span>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <a href="{{ route('admin.units.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
                {{ __('messages.view_all') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- المستأجرين -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">{{ __('messages.tenants') }}</h2>
                    <p class="text-3xl font-bold mt-2">{{ $tenantsCount }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <a href="{{ route('admin.tenants.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-yellow-600 hover:text-yellow-800">
                {{ __('messages.view_all') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    <!-- قسم الرسوم البيانية والإحصائيات -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- إحصائيات الإيجار -->
        <div class="bg-white shadow rounded-lg p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.rental_stats') }}</h2>
            <div class="h-64">
                <canvas id="rentalChart"></canvas>
            </div>
        </div>

        <!-- العقود القريبة من الانتهاء -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.expiring_contracts') }}</h2>
            @if($expiringContracts->count() > 0)
                <ul class="space-y-3">
                    @foreach($expiringContracts as $contract)
                    <li class="border-b pb-2">
                        <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="flex justify-between items-center hover:bg-gray-50 p-2 rounded">
                            <div>
                                <p class="font-medium">{{ $contract->tenant->name }}</p>
                                <p class="text-sm text-gray-500">{{ $contract->unit->unit_number }} - {{ $contract->unit->building->name }}</p>
                            </div>
                            <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                @php $days = floor(now()->diffInDays($contract->end_date)); @endphp
                                    {{ __('messages.days_with_number', ['count' => $days]) }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('admin.contracts.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                    {{ __('messages.view_all_contracts') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <p class="text-gray-500 text-center py-4">{{ __('messages.no_expiring_contracts') }}</p>
            @endif
        </div>
    </div>

    <!-- آخر الأنشطة -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ __('messages.recent_activities') }}</h2>
        <div class="space-y-4">
            @foreach($recentActivities as $activity)
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ $activity->description }}</p>
                    <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- المصروفات والإيرادات -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- إجمالي مصاريف الشهر -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-red-500">
            <h2 class="text-lg font-semibold text-gray-700">{{ __('messages.total_expenses') }}</h2>
            <p class="text-3xl font-bold mt-2 text-red-600">{{ number_format($totalExpenses, 2) }} {{ __('messages.currency') }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ __('messages.total_expenses_description') }}</p>
            <a href="{{ route('admin.expenses.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-red-600 hover:text-red-800">
                {{ __('messages.view_details') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- إجمالي الإيرادات -->
        <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500">
            <h2 class="text-lg font-semibold text-gray-700">{{ __('messages.total_income') }}</h2>
            <p class="text-3xl font-bold mt-2 text-green-600">{{ number_format($totalIncome, 2) }} {{ __('messages.currency') }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ __('messages.total_income_description') }}</p>
            <a href="{{ route('admin.payments.index') }}" class="mt-4 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800">
                {{ __('messages.view_details') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Rental Stats Chart
        const ctx = document.getElementById('rentalChart').getContext('2d');
        const rentalChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: '{{ __('messages.rental_income') }}',
                    data: @json($monthlyIncome),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }, {
                    label: '{{ __('messages.expenses') }}',
                    data: @json($monthlyExpenses),
                    backgroundColor: 'rgba(239, 68, 68, 0.5)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection