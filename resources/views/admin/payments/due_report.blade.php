@extends('layouts.app')

@section('title', __('messages.monthly_due_report'))

@section('content')
<div class="min-h-screen bg-gray-50 rtl:space-x-reverse">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header with Back Button --}}
        <div class="mb-6">
            <div class="flex items-center gap-4 flex-col sm:flex-row">
                <a href="{{ URL::previous() }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 w-full sm:w-auto">
                    <svg class="w-5 h-5 rtl:ml-2 ltr:mr-2 transform rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ __('messages.back') }}
                </a>
                <h1 class="text-2xl font-bold text-gray-900 text-center sm:text-start flex-1">
                    {{ __('messages.monthly_due_report') }}
                </h1>
            </div>
        </div>

        {{-- Report Controls --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ __('messages.report_for') }}: 
                        <span class="text-indigo-600">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}
                        </span>
                    </h2>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('admin.payments.due_report') }}" class="w-full sm:w-auto">
                        <div class="relative">
                            <input type="month" name="month" value="{{ $month }}" 
                                   class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                   onchange="this.form.submit()">
                        </div>
                    </form>
                    
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
					@can('view payment logs')
                        <a href="{{ route('admin.payments.logs.all') }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
                            <svg class="rtl:ml-2 ltr:mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            {{ __('messages.all_payment_logs') }}
                        </a>
						@endcan
                        <a href="{{ route('admin.payments.create') }}"
                           class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 w-full sm:w-auto">
                            <svg class="rtl:ml-2 ltr:mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            {{ __('messages.add_payment') }}
                        </a>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        <a href="{{ route('admin.payments.export_excel', ['month' => $month]) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 w-full sm:w-auto">
                            <svg class="rtl:ml-2 ltr:mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ __('messages.export_excel') }}
                        </a>
                        
                        <a href="{{ route('admin.payments.export_pdf', ['month' => $month]) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 w-full sm:w-auto">
                            <svg class="rtl:ml-2 ltr:mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ __('messages.export_pdf') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Report Table --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.tenant') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                {{ __('messages.contract_code') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                {{ __('messages.building') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                {{ __('messages.unit') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.due_amount') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.paid_amount') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.remaining_amount') }}
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.payment_status') }}
                            </th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                               {{ __('messages.collector_name') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($data as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center rtl:space-x-reverse">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 font-medium">
                                            {{ substr($row['tenant'], 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="rtl:mr-4 ltr:ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $row['tenant'] }}
                                        </div>
                                        <div class="text-sm text-gray-500 sm:hidden">
                                            {{ $row['contract_code'] }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                                {{ $row['contract_code'] }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                {{ $row['building'] }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                                {{ $row['unit'] }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-end">
                                {{ number_format($row['due'], 2) }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-green-600 text-end">
                                {{ number_format($row['paid'], 2) }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-red-600 text-end">
                                {{ number_format($row['remaining'], 2) }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                @if ($row['status'] === 'مدفوع' || $row['status'] === 'Paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ __('messages.paid') }}
                                    </span>
                                @elseif ($row['status'] === 'جزئي' || $row['status'] === 'Partial')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ __('messages.partial') }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ __('messages.unpaid') }}
                                    </span>
                                @endif
                            </td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        {{ $row['collector'] ?? '—' }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('messages.no_data_found') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Summary Section --}}
        @if(!empty($data))
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center rtl:space-x-reverse">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="rtl:mr-5 ltr:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    {{ __('messages.total_due') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ number_format(collect($data)->sum('due'), 2) }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center rtl:space-x-reverse">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="rtl:mr-5 ltr:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    {{ __('messages.total_paid') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-green-600">
                                        {{ number_format(collect($data)->sum('paid'), 2) }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center rtl:space-x-reverse">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="rtl:mr-5 ltr:ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    {{ __('messages.total_remaining') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-red-600">
                                        {{ number_format(collect($data)->sum('remaining'), 2) }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection