@extends('layouts.app')

@section('title', __('messages.edit_assigned_buildings'))

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h1 class="text-2xl font-bold mb-6">{{ __('messages.edit_assigned_buildings') }}</h1>

    <form action="{{ route('admin.building-supervisors.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 🧍‍♂️ معلومات المشرف --}}
        <div>
            <label class="block font-semibold text-sm mb-1">{{ __('messages.supervisor_name') }}</label>
            <input type="text" value="{{ $user->name }}" disabled class="w-full rounded border-gray-300 shadow-sm" />
        </div>

        {{-- 🏢 اختيار المباني --}}
        <div>
            <label class="block font-semibold text-sm mb-2">{{ __('messages.select_buildings') }}</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($buildings as $building)
                    <label class="flex items-center space-x-2 rtl:space-x-reverse">
                        <input type="checkbox" name="buildings[]" value="{{ $building->id }}"
                            {{ $user->buildings->contains($building->id) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                        <span>{{ $building->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- زر الحفظ --}}
        <div>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                {{ __('messages.save_changes') }}
            </button>
        </div>
    </form>
</div>
@endsection
