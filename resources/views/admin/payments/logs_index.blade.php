@extends('layouts.app')

@section('title', __('messages.payment_logs'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ __('messages.payment_logs') }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('messages.payment_logs_description') }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.payments.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        ← {{ __('messages.back_to_payments') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Logs Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.payment') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.user') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.action') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                {{ __('messages.changes') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('messages.date') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $log->payment_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->user->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($log->action === 'created')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ __('messages.created') }}
                                    </span>
                                @elseif ($log->action === 'updated')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ __('messages.updated') }}
                                    </span>
                                @elseif ($log->action === 'deleted')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ __('messages.deleted') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 hidden md:table-cell">
                                <div class="max-w-xs md:max-w-md lg:max-w-lg xl:max-w-xl overflow-auto">
                                    <pre class="text-xs p-2 bg-gray-50 rounded">{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->created_at->format('Y-m-d H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('messages.no_logs_found') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>

<style>
/* Responsive table styles */
@media (max-width: 767px) {
    .max-w-xl {
        max-width: 20rem;
    }
    
    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .bg-gray-50 {
        background-color: #1a202c;
    }
    
    .bg-white {
        background-color: #2d3748;
    }
    
    .text-gray-900 {
        color: #f7fafc;
    }
    
    .text-gray-500 {
        color: #cbd5e0;
    }
    
    .divide-gray-200 {
        border-color: #4a5568;
    }
    
    .bg-gray-100 {
        background-color: #4a5568;
    }
    
    pre {
        background-color: #2d3748;
        color: #f7fafc;
    }
}
</style>
@endsection