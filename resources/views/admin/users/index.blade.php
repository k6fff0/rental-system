@extends('layouts.app')

@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">
                                    {{ __('messages.users_list') }}
                                </h1>
                                <p class="text-blue-100 text-sm mt-1">
                                    {{ __('messages.manage_users_subtitle') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-white text-sm font-medium">
                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ $users->count() }} {{ __('messages.users') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">
                        {{ __('messages.users_data') }}
                    </h2>
                    <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <div class="h-2 w-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-sm text-slate-600">{{ __('messages.live_data') }}</span>
                    </div>
                </div>
            </div>

            <!-- Responsive Table Container -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-100 to-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                {{ __('messages.user_info') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                {{ __('messages.contact_info') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                {{ __('messages.role_specialty') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-all duration-200 group">
                                <!-- User Info Column -->
<td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
        <!-- User Avatar -->
        <div class="flex-shrink-0 relative">
            @if($user->photo_url)
                <a href="{{ asset('storage/' . $user->photo_url) }}" target="_blank">
                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-slate-200 group-hover:ring-blue-300 transition-all duration-200 cursor-pointer" 
                         src="{{ asset('storage/' . $user->photo_url) }}" 
                         alt="{{ $user->name }}"
                         onerror="this.src='{{ asset('images/default-avatar.png') }}'; this.onerror=null;">
                </a>
            @else
                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center ring-2 ring-slate-200 group-hover:ring-blue-300 transition-all duration-200">
                    <span class="text-white font-semibold text-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
            @endif

            <!-- Online Status Indicator -->
            <div class="absolute -bottom-1 -{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}-1 h-4 w-4 bg-green-400 rounded-full border-2 border-white"></div>
        </div>

        <!-- User Details -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                <p class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 transition-colors duration-200">
                    {{ $user->name }}
                </p>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    #{{ $loop->iteration }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                {{ __('messages.member_since') }} {{ $user->created_at->format('M Y') }}
            </p>
        </div>
    </div>
</td>


                                <!-- Contact Info Column -->
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                            <span class="text-sm text-slate-600">{{ $user->email }}</span>
                                        </div>
                                        @if($user->phone)
                                            <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                <span class="text-sm text-slate-600">{{ $user->phone }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

<!-- Role Column -->
<td class="px-6 py-4">
    @php
        $role = $user->getRoleNames()->first(); // أول رول للمستخدم
        $roleColors = [
            'admin' => 'bg-red-100 text-red-800 border-red-200',
            'technician' => 'bg-green-100 text-green-800 border-green-200',
            'user' => 'bg-blue-100 text-blue-800 border-blue-200',
            'supervisor' => 'bg-purple-100 text-purple-800 border-purple-200',
            'broker' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        ];
        $roleColor = $roleColors[$role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
    @endphp

    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $roleColor }}">
        {{ $role ?? 'بدون دور' }}
    </span>
</td>


                                    </div>
                                </td>

                                <!-- Actions Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            {{ __('messages.edit') }}
                                        </a>
                                        
                                        <!-- View Profile Button -->
                                        <button class="inline-flex items-center px-3 py-2 border border-slate-300 text-sm leading-4 font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transform hover:scale-105 transition-all duration-200">
                                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ __('messages.view') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <h3 class="text-lg font-medium text-slate-900 mb-2">{{ __('messages.no_users_found') }}</h3>
                                            <p class="text-slate-500">{{ __('messages.no_users_description') }}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="bg-white px-6 py-4 border-t border-slate-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($users->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-500 bg-white cursor-default">
                                    {{ __('messages.previous') }}
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                                    {{ __('messages.previous') }}
                                </a>
                            @endif

                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                                    {{ __('messages.next') }}
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-500 bg-white cursor-default">
                                    {{ __('messages.next') }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-slate-700">
                                    {{ __('messages.showing') }}
                                    <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                                    {{ __('messages.to') }}
                                    <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                                    {{ __('messages.of') }}
                                    <span class="font-medium">{{ $users->total() }}</span>
                                    {{ __('messages.results') }}
                                </p>
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Custom pagination styles */
    .pagination {
        @apply flex items-center space-x-1;
    }
    
    .pagination li {
        @apply list-none;
    }
    
    .pagination a, .pagination span {
        @apply px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200;
    }
    
    .pagination a {
        @apply text-slate-600 hover:text-blue-600 hover:bg-blue-50;
    }
    
    .pagination .active span {
        @apply bg-blue-600 text-white shadow-lg;
    }
    
    .pagination .disabled span {
        @apply text-slate-400 cursor-not-allowed;
    }

    /* RTL Support */
    [dir="rtl"] .pagination {
        @apply space-x-reverse;
    }
    
    /* Responsive table improvements */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .table-responsive th,
        .table-responsive td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
@endsection