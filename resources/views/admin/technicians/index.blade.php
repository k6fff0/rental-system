@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mb-8 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 dark:text-white transition-colors duration-300">
                                {{ __('messages.technicians_list') }}
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 transition-colors duration-300">
                                {{ __('messages.manage_technicians_description') }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.technicians.specialties.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 hover:border-gray-300 dark:hover:border-gray-500 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                        </svg>
                        {{ __('messages.manage_specialties') }}
                    </a>
                </div>
            </div>

            {{-- Simplified Filter Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <form method="GET" action="{{ route('admin.technicians.index') }}" id="filterForm">
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        {{-- Technician Name Filter --}}
                        <div class="flex-1 w-full">
                            <label for="search_filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-300">
                                <svg class="w-4 h-4 inline {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                {{ __('messages.search_technicians') }}
                            </label>
                            <div class="relative">
                                <input type="text" name="search" id="search_filter" value="{{ request('search') }}"
                                    placeholder="{{ __('messages.enter_technician_name') }}"
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                    autocomplete="off">
                                <div id="search_results"
                                    class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 shadow-lg rounded-lg border border-gray-200 dark:border-gray-600 hidden max-h-60 overflow-auto">
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded-xl hover:bg-blue-700 dark:hover:bg-blue-600 transition-all duration-200 shadow-md hover:shadow-lg">
                            {{ __('messages.search') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Technicians Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                {{-- Mobile View --}}
                <div class="block md:hidden">
                    @forelse ($technicians as $tech)
                        <div class="border-b border-gray-100 dark:border-gray-700 p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">
                                        {{ substr($tech->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 dark:text-white transition-colors duration-300">{{ $tech->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">{{ $tech->email }}</p>
                                    </div>
                                </div>
                                @php
                                    $statusColors = [
                                        'available' => [
                                            'light' => 'bg-green-100 text-green-800',
                                            'dark' => 'dark:bg-green-900/30 dark:text-green-300'
                                        ],
                                        'busy' => [
                                            'light' => 'bg-yellow-100 text-yellow-800',
                                            'dark' => 'dark:bg-yellow-900/30 dark:text-yellow-300'
                                        ],
                                        'unavailable' => [
                                            'light' => 'bg-red-100 text-red-800',
                                            'dark' => 'dark:bg-red-900/30 dark:text-red-300'
                                        ],
                                    ];
                                    $status = $tech->technician_status ?? 'unavailable';
                                    $colorConfig = $statusColors[$status] ?? $statusColors['unavailable'];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorConfig['light'] }} {{ $colorConfig['dark'] }} transition-colors duration-300">
                                    {{ __('messages.status_' . $status) }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 transition-colors duration-300">{{ __('messages.specialty') }}:</p>
                                <p class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">
                                    {{ $tech->mainSpecialty->name ?? __('messages.no_specialty') }}</p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('admin.technicians.show', $tech->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200">
                                    {{ __('messages.view') }}
                                </a>
                                <a href="{{ route('admin.technicians.edit', $tech->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 font-medium rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors duration-200">
                                    {{ __('messages.edit') }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4 transition-colors duration-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium transition-colors duration-300">{{ __('messages.no_technicians_found') }}</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-2 transition-colors duration-300">{{ __('messages.try_different_filters') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Desktop View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700 transition-colors duration-300">
                            <tr>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                    {{ __('messages.technician') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                    {{ __('messages.contact') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                    {{ __('messages.specialty') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                    {{ __('messages.status') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                    {{ __('messages.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                            @forelse ($technicians as $tech)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 shadow-sm transition-colors duration-300">
                                                @if ($tech->photo_url)
                                                    <a href="{{ $tech->photo_url }}"
                                                        data-fancybox="tech-avatar-{{ $tech->id }}">
                                                        <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600 hover:ring-blue-300 dark:hover:ring-blue-500 transition-all duration-200 cursor-pointer"
                                                            src="{{ $tech->photo_url }}" alt="{{ $tech->name }}">
                                                    </a>
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 flex items-center justify-center text-white font-bold">
                                                        {{ strtoupper(substr($tech->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="font-bold text-gray-800 dark:text-white transition-colors duration-300">{{ $tech->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">ID: #{{ $tech->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $tech->email }}</div>
                                        @if ($tech->phone)
                                            <div class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $tech->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">
                                            {{ $tech->mainSpecialty->name ?? __('messages.no_specialty') }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'available' => [
                                                    'bg' => 'bg-green-100 dark:bg-green-900/30',
                                                    'text' => 'text-green-800 dark:text-green-300',
                                                    'dot' => 'bg-green-400 dark:bg-green-500',
                                                ],
                                                'busy' => [
                                                    'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                                    'text' => 'text-yellow-800 dark:text-yellow-300',
                                                    'dot' => 'bg-yellow-400 dark:bg-yellow-500',
                                                ],
                                                'unavailable' => [
                                                    'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                    'text' => 'text-red-800 dark:text-red-300',
                                                    'dot' => 'bg-red-400 dark:bg-red-500',
                                                ],
                                            ];
                                            $status = $tech->technician_status ?? 'unavailable';
                                            $config = $statusConfig[$status] ?? $statusConfig['unavailable'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} transition-colors duration-300">
                                            <span class="w-2 h-2 {{ $config['dot'] }} rounded-full {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                            {{ __('messages.status_' . $status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.technicians.show', $tech->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200 text-sm">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                {{ __('messages.view') }}
                                            </a>
                                            <a href="{{ route('admin.technicians.edit', $tech->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 font-medium rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors duration-200 text-sm">
                                                <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                {{ __('messages.edit') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4 transition-colors duration-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium transition-colors duration-300">
                                            {{ __('messages.no_technicians_found') }}</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2 transition-colors duration-300">{{ __('messages.try_different_filters') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if (method_exists($technicians, 'links'))
                <div class="mt-8 flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                        {{ $technicians->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced search functionality with live results
            const searchInput = document.getElementById('search_filter');
            const searchResults = document.getElementById('search_results');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    if (query.length < 2) {
                        searchResults.classList.add('hidden');
                        return;
                    }

                    fetch(`/admin/technicians/search?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                let html = '';
                                data.forEach(tech => {
                                    html += `
                                <div class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-0 transition-colors duration-200"
                                     onclick="selectTechnician('${tech.name}')">
                                    <div class="font-medium text-gray-800 dark:text-white">${tech.name}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">${tech.email}</div>
                                </div>
                            `;
                                });
                                searchResults.innerHTML = html;
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML =
                                    '<div class="px-4 py-2 text-gray-500 dark:text-gray-400">لا توجد نتائج</div>';
                                searchResults.classList.remove('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            searchResults.classList.add('hidden');
                        });
                });

                // Hide results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('hidden');
                    }
                });
            }

            // Initialize Fancybox for image galleries
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind("[data-fancybox]", {
                    Toolbar: {
                        display: {
                            left: ["infobar"],
                            middle: [],
                            right: ["slideshow", "download", "thumbs", "close"],
                        },
                    },
                });
            }
        });

        function selectTechnician(name) {
            const searchInput = document.getElementById('search_filter');
            const searchResults = document.getElementById('search_results');
            searchInput.value = name;
            searchResults.classList.add('hidden');
            document.getElementById('filterForm').submit();
        }
    </script>

    <style>
        /* Enhanced Dark Mode Styles */
        
        /* Smooth transitions for all elements */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* Custom scrollbar for dark mode */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: theme('colors.gray.100');
        }

        .dark ::-webkit-scrollbar-track {
            background: theme('colors.gray.700');
        }

        ::-webkit-scrollbar-thumb {
            background: theme('colors.gray.300');
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: theme('colors.gray.600');
        }

        ::-webkit-scrollbar-thumb:hover {
            background: theme('colors.gray.400');
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: theme('colors.gray.500');
        }

        /* Enhanced focus styles for dark mode */
        input:focus,
        button:focus,
        a:focus {
            outline: 2px solid theme('colors.blue.500');
            outline-offset: 2px;
        }

        .dark input:focus,
        .dark button:focus,
        .dark a:focus {
            outline-color: theme('colors.blue.400');
        }

        /* Button hover effects */
        button:hover,
        a:hover {
            transform: translateY(-1px);
        }

        button:active,
        a:active {
            transform: translateY(0);
        }

        /* Enhanced gradient backgrounds for dark mode */
        .dark .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, theme('colors.gray.900'), theme('colors.gray.800'));
        }

        /* Table row hover effects */
        tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dark tbody tr:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Card shadow effects for dark mode */
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        /* Avatar ring effects */
        .ring-2 {
            box-shadow: 0 0 0 2px currentColor;
        }

        /* Status badge pulse animation */
        @keyframes pulse-status {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        .status-badge {
            animation: pulse-status 2s infinite;
        }

        /* Search results dropdown styling */
        #search_results {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Mobile responsiveness improvements */
        @media (max-width: 768px) {
            .w-12.h-12 {
                width: 2.5rem;
                height: 2.5rem;
            }
            
            .text-2xl.lg\\:text-3xl {
                font-size: 1.25rem;
            }
            
            .px-8 {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .border {
                border-width: 2px;
            }
            
            .shadow-xl,
            .shadow-lg {
                box-shadow: 0 0 0 1px currentColor;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *,
            ::before,
            ::after {
                animation-delay: -1ms !important;
                animation-duration: 1ms !important;
                animation-iteration-count: 1 !important;
                background-attachment: initial !important;
                scroll-behavior: auto !important;
                transition-duration: 0s !important;
                transition-delay: 0s !important;
            }
        }

        /* Print styles */
        @media print {
            .dark .bg-gray-800,
            .dark .bg-gray-700 {
                background-color: white !important;
                color: black !important;
            }
            
            .shadow-xl,
            .shadow-lg {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
            
            .bg-gradient-to-br,
            .bg-gradient-to-r {
                background: white !important;
            }
        }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid theme('colors.blue.500');
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Enhanced RTL support */
        [dir="rtl"] .mr-2 {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        [dir="rtl"] .ml-2 {
            margin-left: 0;
            margin-right: 0.5rem;
        }

        [dir="rtl"] .mr-1 {
            margin-right: 0;
            margin-left: 0.25rem;
        }

        [dir="rtl"] .ml-1 {
            margin-left: 0;
            margin-right: 0.25rem;
        }

        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus visible for better keyboard navigation */
        .focus\\:ring-2:focus-visible {
            box-shadow: 0 0 0 2px theme('colors.blue.500');
        }

        .dark .focus\\:ring-2:focus-visible {
            box-shadow: 0 0 0 2px theme('colors.blue.400');
        }

        /* Skip to content link */
        .skip-to-content {
            position: absolute;
            top: -40px;
            left: 6px;
            background: theme('colors.blue.600');
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
        }

        .skip-to-content:focus {
            top: 6px;
        }

        /* Enhanced button states */
        button:disabled,
        a.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Tooltip styles for status badges */
        .tooltip {
            position: relative;
        }

        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: theme('colors.gray.900');
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .dark .tooltip::after {
            background: theme('colors.gray.100');
            color: theme('colors.gray.900');
        }

        .tooltip:hover::after {
            opacity: 1;
        }

        /* Custom pagination styles for dark mode */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid theme('colors.gray.300');
            background: white;
            color: theme('colors.gray.700');
            text-decoration: none;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .dark .pagination a,
        .dark .pagination span {
            border-color: theme('colors.gray.600');
            background: theme('colors.gray.800');
            color: theme('colors.gray.300');
        }

        .pagination a:hover {
            background: theme('colors.gray.50');
            border-color: theme('colors.gray.400');
        }

        .dark .pagination a:hover {
            background: theme('colors.gray.700');
            border-color: theme('colors.gray.500');
        }

        .pagination .active {
            background: theme('colors.blue.600');
            border-color: theme('colors.blue.600');
            color: white;
        }

        /* Animation for page transitions */
        .page-transition {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection