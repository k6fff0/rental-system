@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.tenants_list') }}</h1>
        <a href="{{ route('admin.tenants.create') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold shadow">
            + {{ __('messages.add_tenant') }}
        </a>
    </div>
{{-- 🔍 البحث الذكي --}}
<form method="GET" class="mb-4">
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="{{ __('messages.search_placeholder') }}"
               class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-semibold shadow">
            {{ __('messages.search') }}
        </button>
    </div>
</form>

    {{-- عرض المستأجرين --}}
    @if ($tenants->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_tenants') }}
        </div>
    @else
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

                                @if ($tenant->tenant_status === 'active' && $tenant->unit_id)
                                    <form action="{{ route('admin.tenants.unlink-unit', $tenant->id) }}" method="POST"
                                          class="inline"
                                          onsubmit="return confirm('{{ __('messages.confirm_unlink_unit') }}')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-orange-600 hover:underline">{{ __('messages.unlink_unit') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- روابط الصفحات --}}
        <div class="mt-6">
            {{ $tenants->links() }}
        </div>
    @endif

</div>
@endsection
