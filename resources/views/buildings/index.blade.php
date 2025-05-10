@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.building_list') }}</h1>
        <a href="{{ route('admin.buildings.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
            + {{ __('messages.add_building') }}
        </a>
    </div>

    {{-- لا توجد مباني --}}
    @if ($buildings->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_buildings') }}
        </div>
    @else
        {{-- جدول عرض المباني --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('messages.building_name') }}</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('messages.address') }}</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-800">
    @foreach ($buildings as $building)
        <tr class="border-t hover:bg-gray-50">
            <td class="px-6 py-3">{{ $building->name }}</td>
            <td class="px-6 py-3">{{ $building->address }}</td>
            <td class="px-6 py-3">
                <div class="flex items-center gap-2">
                    {{-- ✅ زر التعديل --}}
                    <a href="{{ route('admin.buildings.edit', ['building' => $building->id]) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium shadow transition">
                        {{ __('messages.edit') }}
                    </a>

                    {{-- ✅ زر الحذف --}}
                    <form action="{{ route('admin.buildings.destroy', ['building' => $building->id]) }}"
                          method="POST"
                          onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-medium shadow transition">
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>>
            </table>
        </div>
    @endif

</div>
@endsection
