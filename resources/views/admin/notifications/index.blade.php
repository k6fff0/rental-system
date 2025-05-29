@extends('layouts.app')
@section('title', __('messages.notifications'))
@section('content')

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto w-12 h-12 bg-indigo-500 rounded-lg flex items-center justify-center mb-4 shadow-md">
                    <x-heroicon-o-megaphone class="w-6 h-6 text-white" />


                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    {{ __('messages.notifications') }}
                </h1>
                <p class="text-gray-600">
                    {{ __('messages.stay_updated_with_latest') ?? 'آخر الإشعارات والتحديثات' }}
                </p>
            </div>

            @if ($notifications->count() > 0)
                <!-- Notifications List -->
                <div class="space-y-3">
                    @foreach ($notifications as $notification)
                        <div
                            class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100 overflow-hidden">
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="block p-4 hover:bg-gray-50">
                                <div class="flex items-start gap-3">
                                    <!-- Icon -->
                                    <div
                                        class="w-8 h-8 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                        <x-heroicon-o-megaphone class="w-5 h-5" />
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-medium text-gray-800">
                                                {{ $notification->data['title'] ?? __('messages.notification') }}
                                                @if (!$notification->read_at)
                                                    <x-heroicon-o-megaphone class="w-6 h-6 text-white" />
                                                @endif
                                            </h3>
                                            <span class="text-xs text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination - Simple -->
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <x-heroicon-o-megaphone class="w-6 h-6 text-white" />

                    </div>
                    <h3 class="text-lg font-medium text-gray-700 mb-2">
                        {{ __('messages.no_notifications') }}
                    </h3>
                    <p class="text-gray-500">
                        {{ __('messages.no_notifications_description') ?? 'لا توجد إشعارات لعرضها حالياً' }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Small animation for notifications */
        @media (min-width: 640px) {
            .hover\:shadow-md {
                transition: all 0.2s ease;
            }
        }
    </style>

@endsection
