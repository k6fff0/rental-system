@extends('layouts.app')

@section('title', __('messages.building_supervisors'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Enhanced Page Header --}}
        <div class="mb-10">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white text-xl">🏢</span>
                            </div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                {{ __('messages.building_supervisors') }}
                            </h1>
                        </div>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            {{ __('messages.manage_building_supervisors') }}
                        </p>
                    </div>
                    <div class="mt-6 sm:mt-0 flex flex-col sm:flex-row gap-3">
                        <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 text-center">
                            <div class="text-2xl font-bold text-blue-700">{{ $users->total() ?? $users->count() }}</div>
                            <div class="text-sm text-blue-600 font-medium">{{ __('messages.total_supervisors') ?? 'Total Supervisors' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Enhanced Table Container --}}
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
            {{-- Table Header with Search/Filter Area --}}
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <span class="w-2 h-6 bg-blue-500 rounded-full {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}"></span>
                        {{ __('messages.supervisors_list') ?? 'Supervisors List' }}
                    </h2>
                </div>
            </div>

            {{-- Enhanced Responsive Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ __('messages.name') }}</span>
                                    <div class="w-1 h-4 bg-blue-400 rounded-full opacity-60"></div>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200 hidden sm:table-cell">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ __('messages.email') }}</span>
                                    <div class="w-1 h-4 bg-green-400 rounded-full opacity-60"></div>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ __('messages.assigned_buildings') }}</span>
                                    <div class="w-1 h-4 bg-purple-400 rounded-full opacity-60"></div>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ __('messages.actions') }}</span>
                                    <div class="w-1 h-4 bg-orange-400 rounded-full opacity-60"></div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 group">
                            {{-- Name & Phone Column --}}
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 relative">
                                        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 border-2 border-white">
                                            <span class="text-blue-700 font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white shadow-sm"></div>
                                    </div>
                                    <div class="ml-4 rtl:ml-0 rtl:mr-4 flex-1 min-w-0">
                                        <div class="text-base font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300 truncate">
                                            {{ $user->name }}
                                        </div>
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                📱 {{ $user->phone ?? __('messages.no_phone') }}
                                            </span>
                                        </div>
                                        {{-- Show email on mobile --}}
                                        <div class="sm:hidden mt-2">
                                            <span class="text-sm text-gray-600 bg-green-50 px-2 py-1 rounded-lg border border-green-200">
                                                ✉️ {{ $user->email }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Email Column (Hidden on mobile) --}}
                            <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    <span class="font-medium">{{ $user->email }}</span>
                                </div>
                            </td>

                            {{-- Buildings Column --}}
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" 
                                            class="inline-flex items-center px-4 py-2 border-2 border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-gradient-to-r from-white to-gray-50 hover:from-blue-50 hover:to-blue-100 hover:border-blue-300 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 group">
                                        <span class="flex items-center space-x-2 rtl:space-x-reverse">
                                            <span class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <span class="text-purple-600 text-xs font-bold">{{ $user->buildings->count() }}</span>
                                            </span>
                                            <span>{{ __('messages.buildings_count', ['count' => $user->buildings->count()]) }}</span>
                                        </span>
                                        <svg class="-mr-1 ml-2 rtl:ml-0 rtl:mr-2 h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" 
                                             :class="{ 'rotate-180': open }" 
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-200" 
                                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2" 
                                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" 
                                         x-transition:leave="transition ease-in duration-150" 
                                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" 
                                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                         @click.away="open = false"
                                         class="origin-top absolute z-50 mt-2 w-72 rounded-2xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 border border-gray-200"
                                         :class="{'right-0 rtl:right-auto rtl:left-0': '{{ app()->getLocale() }}' === 'ar', 'left-0 rtl:left-auto rtl:right-0': '{{ app()->getLocale() }}' === 'en'}"
                                         style="display: none;">
                                        <div class="p-2">
                                            <div class="px-4 py-3 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl mb-2">
                                                <h4 class="text-sm font-semibold text-gray-800">{{ __('messages.assigned_buildings') ?? 'Assigned Buildings' }}</h4>
                                            </div>
                                            <div class="max-h-60 overflow-y-auto space-y-1">
                                                @forelse($user->buildings as $building)
                                                    <div class="flex items-center space-x-3 rtl:space-x-reverse px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 rounded-xl transition-colors duration-200">
                                                        <div class="w-2 h-2 bg-blue-400 rounded-full flex-shrink-0"></div>
                                                        <span class="font-medium flex-1">{{ $building->name }}</span>
                                                    </div>
                                                @empty
                                                    <div class="flex items-center justify-center px-4 py-8 text-sm text-gray-500">
                                                        <div class="text-center">
                                                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                                                <span class="text-gray-400 text-xl">🏢</span>
                                                            </div>
                                                            <span class="italic">{{ __('messages.no_buildings_assigned') }}</span>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Actions Column --}}
                            <td class="px-6 py-6 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.building-supervisors.edit', $user->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                    {{ __('messages.edit') }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-4">
                                        <span class="text-gray-400 text-3xl">🔍</span>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('messages.no_data_found') }}</h3>
                                    <p class="text-gray-500 text-sm">{{ __('messages.no_supervisors_message') ?? 'No building supervisors found.' }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Enhanced Pagination --}}
            @if($users->hasPages())
                <div class="px-6 py-6 bg-gradient-to-r from-gray-50 to-white border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            <span class="font-medium">{{ __('messages.showing') ?? 'Showing' }}</span>
                            <span class="font-bold text-blue-600">{{ $users->firstItem() }}</span>
                            {{ __('messages.to') ?? 'to' }}
                            <span class="font-bold text-blue-600">{{ $users->lastItem() }}</span>
                            {{ __('messages.of') ?? 'of' }}
                            <span class="font-bold text-blue-600">{{ $users->total() }}</span>
                            <span class="font-medium">{{ __('messages.results') ?? 'results' }}</span>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Custom CSS for enhanced styling --}}
<style>
/* Custom pagination styling */
.pagination-wrapper .pagination {
    @apply flex items-center space-x-1 rtl:space-x-reverse;
}

.pagination-wrapper .page-link {
    @apply px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 transition-all duration-200;
}

.pagination-wrapper .page-item.active .page-link {
    @apply bg-blue-600 text-white border-blue-600 shadow-lg;
}

.pagination-wrapper .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed hover:bg-white hover:text-gray-400 hover:border-gray-300;
}

/* RTL specific styles */
[dir="rtl"] .pagination-wrapper .pagination {
    @apply space-x-reverse;
}

/* Mobile responsiveness improvements */
@media (max-width: 640px) {
    .max-w-7xl {
        @apply px-2;
    }
    
    table th, table td {
        @apply px-3 py-3;
    }
    
    .pagination-wrapper {
        @apply overflow-x-auto;
    }
}

/* Smooth animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hover\:animate-slideIn:hover {
    animation: slideIn 0.3s ease-out;
}
</style>
@endsection