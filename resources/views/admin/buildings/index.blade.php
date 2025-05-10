@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ➕ زر إضافة مبنى --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.building_list') }}</h1>
        <a href="{{ route('admin.buildings.create') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
            + {{ __('messages.add_building') }}
        </a>
    </div>

    {{-- 📭 لا توجد مباني --}}
    @if ($buildings->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_buildings') }}
        </div>
    @else
        {{-- 📋 جدول عرض المباني --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-gray-800">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        @if(app()->getLocale() == 'ar')
                            <th class="px-4 py-3 text-right">{{ __('messages.building_name') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('messages.address') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('messages.unit_count') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('messages.actions') }}</th>
                        @else
                            <th class="px-4 py-3 text-left">{{ __('messages.building_name') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('messages.address') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('messages.unit_count') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('messages.actions') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buildings as $building)
                        <tr class="border-t hover:bg-gray-50">
                            @if(app()->getLocale() == 'ar')
                                <td class="px-4 py-3 text-right">{{ $building->name }}</td>
                                <td class="px-4 py-3 text-right">{{ $building->address }}</td>
                                <td class="px-4 py-3 text-right">{{ $building->units->count() }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 justify-end flex-row-reverse">
                                        <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                           class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                           تعديل
                                        </a>
                                        <form action="{{ route('admin.buildings.destroy', $building->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @else
                                <td class="px-4 py-3">{{ $building->name }}</td>
                                <td class="px-4 py-3">{{ $building->address }}</td>
                                <td class="px-4 py-3">{{ $building->units->count() }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 justify-start flex-row">
                                        <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                           class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                           Edit
                                        </a>
                                        <form action="{{ route('admin.buildings.destroy', $building->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
