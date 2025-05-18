@extends('layouts.app')

@section('content')
<div class="mx-4 py-4 sm:mx-auto max-w-7xl" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ✅ العنوان وزر الإضافة --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ __('messages.tenants_list') }}</h1>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="{{ route('admin.tenants.create') }}"
               class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 text-center flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('messages.add_tenant') }}
            </a>
        </div>
    </div>

    {{-- ✅ فلتر البحث --}}
    <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm">
        <form method="GET" class="flex flex-col sm:flex-row gap-3" id="smartSearchForm">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                       placeholder="{{ __('messages.search_placeholder') }}"
                       class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10' : 'pl-10' }} py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm transition-colors duration-200">
                {{ __('messages.search') }}
            </button>
        </form>
    </div>

    {{-- ✅ عرض المستأجرين --}}
    @if ($tenants->isEmpty())
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-3 text-lg">{{ __('messages.no_tenants') }}</p>
        </div>
    @else
        <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.full_name') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">{{ __('messages.id_number') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.phone') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">{{ __('messages.unit_number') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.status') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell">{{ __('messages.has_debt') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell">{{ __('messages.has_account') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($tenants as $tenant)
                            @php
                                $status = $tenant->tenant_status;
                                $colors = [
                                    'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'late_payer' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'has_debt' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'absent' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    'abroad' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'legal_issue' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $tenant->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                    {{ $tenant->id_number ?? '-' }}
                                </td>
                               <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                 <div class="flex items-center gap-2">
                                   {{-- ✅ عرض الرقم دائماً --}}
                                   <span>{{ $tenant->phone ?? '-' }}</span>

                                   {{-- ✅ فقط على الشاشات الصغيرة: أيقونة اتصال --}}
                                 <a href="tel:{{ $tenant->phone }}" class="sm:hidden text-green-600 hover:text-green-800" title="{{ __('messages.call') }}">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                   </svg>
                                 </a>

                                      {{-- ✅ فقط على الشاشات المتوسطة وفوق: زر منقط (ديكور فقط، ما عليهش رابط) --}}
                                  <div class="hidden sm:inline-block text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                   <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM18 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                              </div>
                              </div>
                              </td>

                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden md:table-cell">
                                    {{ $tenant->unit?->unit_number ?? '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ __('messages.tenant_status_' . $status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm hidden lg:table-cell">
                                    @if($tenant->debt > 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300">
                                            {{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                            {{ __('messages.no') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm hidden lg:table-cell">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium {{ $tenant->user ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                        {{ $tenant->user ? __('messages.yes') : __('messages.no') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM18 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </button>
        <div x-show="open" @click.away="open = false"
             x-transition
             class="absolute z-10 {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
             style="display: none;">
            <div class="py-1">
                <a href="tel:{{ $tenant->phone }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center gap-2 sm:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ __('messages.call') }}
                </a>

                <a href="{{ route('admin.tenants.show', $tenant->id) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ __('messages.view') }}
                </a>
                <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ __('messages.edit') }}
                </a>
                @if (!$tenant->user)
                    <a href="{{ route('admin.tenants.link-user', $tenant->id) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('messages.link_to_account') }}
                    </a>
                @endif
                <form action="{{ route('admin.tenants.destroy', $tenant->id) }}" method="POST" class="block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('{{ __('messages.confirm_delete') }}')"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $tenants->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('searchInput');
        let timeout = null;
        input.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                document.getElementById('smartSearchForm').submit();
            }, 500);
        });
    });
</script>
@endpush
@endsection