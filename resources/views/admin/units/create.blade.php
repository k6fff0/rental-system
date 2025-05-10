@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">{{ __('messages.add_unit') }}</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.units.store') }}">
        @csrf

        <div class="mb-4">
            <label for="building_id" class="block mb-1">{{ __('messages.select_building') }}</label>
            <select name="building_id" id="building_id" class="w-full border border-gray-300 p-2 rounded">
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="unit_number" class="block mb-1">{{ __('messages.unit_number') }}</label>
            <input type="text" name="unit_number" id="unit_number" class="w-full border border-gray-300 p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="floor" class="block mb-1">{{ __('messages.floor') }}</label>
            <input type="number" name="floor" id="floor" class="w-full border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="type" class="block mb-1">{{ __('messages.unit_type') }}</label>
            <input type="text" name="type" id="type" class="w-full border border-gray-300 p-2 rounded" placeholder="{{ __('messages.unit_type_placeholder') }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            {{ __('messages.save') }}
        </button>
    </form>
</div>
@endsection
