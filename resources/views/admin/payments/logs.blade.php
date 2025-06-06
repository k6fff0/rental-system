@extends('layouts.app')

@section('title', __('messages.payment_logs'))

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
            {{ __('messages.payment_logs') }} - {{ $payment->id }}
        </h1>

        <a href="{{ route('admin.payments.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">
            ← {{ __('messages.back') }}
        </a>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-start">{{ __('messages.user') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.action') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.changes') }}</th>
                        <th class="px-4 py-3 text-start">{{ __('messages.date_time') }}</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 divide-y">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-4 py-2 font-medium">{{ $log->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if ($log->action === 'updated')
                                    📝 {{ __('messages.updated') }}
                                @elseif ($log->action === 'deleted')
                                    ❌ {{ __('messages.deleted') }}
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @php
                                    $changes = is_string($log->changes)
                                        ? json_decode($log->changes, true)
                                        : $log->changes;
                                @endphp

                                <div class="grid grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <div class="font-semibold mb-1">{{ __('messages.before') }}:</div>
                                        <ul class="list-disc list-inside text-gray-600">
                                            @foreach ($changes['before'] ?? [] as $key => $value)
                                                <li>{{ $key }}: {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="font-semibold mb-1">{{ __('messages.after') }}:</div>
                                        <ul class="list-disc list-inside text-gray-600">
                                            @foreach ($changes['after'] ?? [] as $key => $value)
                                                <li>{{ $key }}: {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">{{ __('messages.no_logs_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
