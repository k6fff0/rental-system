@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8"> <!-- زادت من max-w-4xl إلى max-w-6xl -->

            {{-- Header Section --}}
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">
                                {{ __('messages.technicians_list') }}
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ __('messages.manage_technicians_description') }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.technicians.specialties.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-md hover:shadow-lg">
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
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <form method="GET" action="{{ route('admin.technicians.index') }}" id="filterForm">
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        {{-- Technician Name Filter --}}
                        <div class="flex-1 w-full">
                            <label for="search_filter" class="block text-sm font-semibold text-gray-700 mb-1">
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
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    autocomplete="off">
                                <div id="search_results"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-lg hidden max-h-60 overflow-auto">
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all duration-200">
                            {{ __('messages.search') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Technicians Table --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                {{-- Mobile View --}}
                <div class="block md:hidden">
                    @forelse ($technicians as $tech)
                        <div class="border-b border-gray-100 p-6 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr($tech->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $tech->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $tech->email }}</p>
                                    </div>
                                </div>
                                @php
                                    $statusColors = [
                                        'available' => 'bg-green-100 text-green-800',
                                        'busy' => 'bg-yellow-100 text-yellow-800',
                                        'unavailable' => 'bg-red-100 text-red-800',
                                    ];
                                    $status = $tech->technician_status ?? 'unavailable';
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$status] ?? '' }}">
                                    {{ __('messages.status_' . $status) }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">{{ __('messages.specialty') }}:</p>
                                <p class="font-medium text-gray-800">
                                    {{ $tech->mainSpecialty->name ?? __('messages.no_specialty') }}</p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('admin.technicians.show', $tech->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                    {{ __('messages.view') }}
                                </a>
                                <a href="{{ route('admin.technicians.edit', $tech->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-yellow-100 text-yellow-700 font-medium rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                                    {{ __('messages.edit') }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">{{ __('messages.no_technicians_found') }}</p>
                            <p class="text-gray-400 text-sm mt-2">{{ __('messages.try_different_filters') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Desktop View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200"> <!-- تغيير من min-w-full إلى w-full -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <!-- زيادة padding-x من 6 إلى 8 -->
                                    {{ __('messages.technician') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('messages.contact') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('messages.specialty') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('messages.status') }}
                                </th>
                                <th class="px-8 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ __('messages.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($technicians as $tech)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-8 py-4 whitespace-nowrap"> <!-- إضافة whitespace-nowrap -->
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 border border-gray-300 shadow-sm">
                                                @if ($tech->photo_url)
                                                    <img src="{{ asset('storage/' . $tech->photo_url) }}"
                                                        alt="{{ $tech->name }}" class="object-cover w-full h-full">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                                        {{ strtoupper(substr($tech->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="font-bold text-gray-800">{{ $tech->name }}</div>
                                                <div class="text-sm text-gray-500">ID: #{{ $tech->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800">{{ $tech->email }}</div>
                                        @if ($tech->phone)
                                            <div class="text-sm text-gray-500">{{ $tech->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800">
                                            {{ $tech->mainSpecialty->name ?? __('messages.no_specialty') }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'available' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-800',
                                                    'dot' => 'bg-green-400',
                                                ],
                                                'busy' => [
                                                    'bg' => 'bg-yellow-100',
                                                    'text' => 'text-yellow-800',
                                                    'dot' => 'bg-yellow-400',
                                                ],
                                                'unavailable' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-800',
                                                    'dot' => 'bg-red-400',
                                                ],
                                            ];
                                            $status = $tech->technician_status ?? 'unavailable';
                                            $config = $statusConfig[$status] ?? $statusConfig['unavailable'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                            <span
                                                class="w-2 h-2 {{ $config['dot'] }} rounded-full {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}"></span>
                                            {{ __('messages.status_' . $status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.technicians.show', $tech->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 transition-colors duration-200 text-sm">
                                                <!-- تغيير حجم النص من xs إلى sm -->
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
                                                class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 font-medium rounded-lg hover:bg-yellow-200 transition-colors duration-200 text-sm">
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
                                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">
                                            {{ __('messages.no_technicians_found') }}</p>
                                        <p class="text-gray-400 text-sm mt-2">{{ __('messages.try_different_filters') }}
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
                    {{ $technicians->links() }}
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
                                <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-0"
                                     onclick="selectTechnician('${tech.name}')">
                                    <div class="font-medium text-gray-800">${tech.name}</div>
                                    <div class="text-xs text-gray-500">${tech.email}</div>
                                </div>
                            `;
                                });
                                searchResults.innerHTML = html;
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML =
                                    '<div class="px-4 py-2 text-gray-500">No results found</div>';
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
        });

        function selectTechnician(name) {
            const searchInput = document.getElementById('search_filter');
            searchInput.value = name;
            document.getElementById('filterForm').submit();
        }
    </script>
@endsection
