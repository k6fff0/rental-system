@extends('layouts.app')

@section('title', __('messages.view_all_notifications'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        🔔 {{ __('messages.view_all_notifications') }}
    </h1>

    @php
        $role = auth()->user()?->getRoleNames()?->first(); // هنفترض إنه عنده Role
        $notifications = auth()->user()
            ->notifications
            ->filter(fn($n) => $n->data['target'] === $role);
    @endphp

    @forelse ($notifications as $notification)
        @php
            $data = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-dynamic-component :component="$data['icon'] ?? 'heroicon-o-information-circle'" class="h-5 w-5 text-blue-500" />
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $data['title'] ?? 'إشعار' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $data['message'] ?? '' }}</p>
                    </div>
                </div>
                <span class="text-xs text-gray-400 dark:text-gray-500">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    @empty
        <p class="text-gray-600 dark:text-gray-300">{{ __('messages.no_notifications') }}</p>
    @endforelse
</div>
@endsection
