@extends('layouts.app')

@section('title', __('messages.unauthorized_title'))

@section('content')
<div class="pt-20 px-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-[calc(100vh-100px)]">
    <div class="w-full max-w-md mx-auto text-center p-6 rounded-xl shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        
        <!-- أيقونة -->
        <div class="mx-auto w-20 h-20 mb-6 text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 0v4m0-4h4m-4 0H8" />
            </svg>
        </div>

        <!-- رمز الخطأ -->
        <h1 class="text-5xl font-bold text-red-600 mb-2">403</h1>

        <!-- عنوان -->
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
            {{ __('messages.unauthorized_access') }}
        </h2>

        <!-- وصف -->
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('messages.unauthorized_description') }}
        </p>
    </div>
</div>
@endsection
