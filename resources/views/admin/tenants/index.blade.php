@extends('layouts.app')

@section('content')
<div class="mx-4 py-4 sm:mx-auto" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ __('messages.tenants_list') }}</h1>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="{{ route('admin.tenants.create') }}"
               class="flex-1 sm:flex-none bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold shadow text-center">
                + {{ __('messages.add_tenant') }}
            </a>
        </div>
    </div>

    {{-- 🔍 البحث الذكي --}}
    <form method="GET" class="mb-4" id="smartSearchForm">
        <div class="relative">
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                   placeholder="{{ __('messages.search_placeholder') }}"
                   class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} flex items-center pr-3">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('searchInput');
            let timeout = null;

            input.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    document.getElementById('smartSearchForm').submit();
                }, 500);
            });
        });
    </script>
    @endpush

    {{-- عرض المستأجرين --}}
    @if ($tenants->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_tenants') }}
        </div>
    @else
        <div class="space-y-3 sm:hidden"> {{-- عرض الجوال --}}
            @foreach ($tenants as $tenant)
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $tenant->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $tenant->unit?->unit_number ?? '-' }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded 
                        @if($tenant->tenant_status === 'active') bg-green-100 text-green-800
                        @elseif($tenant->tenant_status === 'late_payer') bg-yellow-100 text-yellow-800
                        @elseif($tenant->tenant_status === 'has_debt') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ __('messages.tenant_status_' . $tenant->tenant_status) }}
                    </span>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-500">{{ __('messages.id_number') }}:</span>
                        <span>{{ $tenant->id_number ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">{{ __('messages.phone') }}:</span>
                        <span>{{ $tenant->phone ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">{{ __('messages.has_debt') }}:</span>
                        @if($tenant->debt > 0)
                            <span class="text-red-600 font-bold">{{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}</span>
                        @else
                            <span class="text-green-600">{{ __('messages.no') }}</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-gray-500">{{ __('messages.has_account') }}:</span>
                        @if ($tenant->user)
                            <span class="text-green-600">{{ __('messages.yes') }}</span>
                        @else
                            <span class="text-red-600">{{ __('messages.no') }}</span>
                        @endif
                    </div>
                </div>

               <div class="mt-4 pt-3 border-t border-gray-100 flex flex-wrap gap-2 text-sm">

    {{-- عرض --}}
    <a href="{{ route('admin.tenants.show', $tenant->id) }}"
       class="inline-flex items-center gap-1 px-3 py-1 rounded bg-blue-100 text-blue-800 font-medium shadow hover:bg-blue-200 transition">
        <i class="fas fa-eye text-xs"></i>
        <span>{{ __('messages.view') }}</span>
    </a>

    {{-- تعديل --}}
    <a href="{{ route('admin.tenants.edit', $tenant->id) }}"
       class="inline-flex items-center gap-1 px-3 py-1 rounded bg-indigo-100 text-indigo-800 font-medium shadow hover:bg-indigo-200 transition">
        <i class="fas fa-edit text-xs"></i>
        <span>{{ __('messages.edit') }}</span>
    </a>

    {{-- حذف --}}
    <form action="{{ route('admin.tenants.destroy', $tenant->id) }}" method="POST"
          onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center gap-1 px-3 py-1 rounded bg-red-100 text-red-800 font-medium shadow hover:bg-red-200 transition">
            <i class="fas fa-trash text-xs"></i>
            <span>{{ __('messages.delete') }}</span>
        </button>
    </form>

    {{-- ربط بحساب (لو مفيش يوزر) --}}
    @if (!$tenant->user)
        <a href="{{ route('admin.tenants.link-user', $tenant->id) }}"
           class="inline-flex items-center gap-1 px-3 py-1 rounded bg-green-100 text-green-800 font-medium shadow hover:bg-green-200 transition">
            <i class="fas fa-link text-xs"></i>
            <span>{{ __('messages.link_to_account') }}</span>
        </a>
    @endif

</div>

            </div>
            @endforeach
        </div>

        <div class="hidden sm:block"> {{-- عرض سطح المكتب --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-start">{{ __('messages.full_name') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.id_number') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.phone') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.unit_number') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.status') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.has_debt') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.has_account') }}</th>
                            <th class="px-4 py-3 text-start">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                        @foreach ($tenants as $tenant)
                            <tr>
                                <td class="px-4 py-3">{{ $tenant->name }}</td>
                                <td class="px-4 py-3">{{ $tenant->id_number ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $tenant->phone ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $tenant->unit?->unit_number ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $status = $tenant->tenant_status;
                                        $colors = [
                                            'active' => 'bg-green-100 text-green-800',
                                            'late_payer' => 'bg-yellow-100 text-yellow-800',
                                            'has_debt' => 'bg-red-100 text-red-800',
                                            'absent' => 'bg-gray-100 text-gray-800',
                                            'abroad' => 'bg-blue-100 text-blue-800',
                                            'legal_issue' => 'bg-purple-100 text-purple-800',
                                        ];
                                    @endphp
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ __('messages.tenant_status_' . $status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($tenant->debt > 0)
                                        <span class="text-red-600 font-bold">{{ number_format($tenant->debt, 2) }} {{ __('messages.currency') }}</span>
                                    @else
                                        <span class="text-green-600">{{ __('messages.no') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($tenant->user)
                                        <span class="text-green-600 font-medium">{{ __('messages.yes') }}</span>
                                    @else
                                        <span class="text-red-600 font-medium">{{ __('messages.no') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 space-x-2 rtl:space-x-reverse whitespace-nowrap">
                                    <a href="{{ route('admin.tenants.show', $tenant->id) }}"
                                       class="text-blue-600 hover:underline">{{ __('messages.view') }}</a>

                                    <a href="{{ route('admin.tenants.edit', $tenant->id) }}"
                                       class="text-indigo-600 hover:underline">{{ __('messages.edit') }}</a>

                                    <form action="{{ route('admin.tenants.destroy', $tenant->id) }}" method="POST"
                                          class="inline"
                                          onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">{{ __('messages.delete') }}</button>
                                    </form>

                                    @if (!$tenant->user)
                                        <a href="{{ route('admin.tenants.link-user', $tenant->id) }}"
                                           class="text-blue-600 hover:underline">{{ __('messages.link_to_account') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- روابط الصفحات --}}
        <div class="mt-6">
            {{ $tenants->links() }}
        </div>
    @endif

</div>
@endsection