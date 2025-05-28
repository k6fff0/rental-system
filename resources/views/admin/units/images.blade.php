@extends('layouts.app')

@section('title', __('messages.unit_images'))

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    
    {{-- ✅ العنوان --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.unit_images') }} - {{ $unit->unit_number }}</h1>
        <p class="text-sm text-gray-500">{{ __('messages.unit_status') }}: <span class="font-semibold">{{ __('units.status.' . $unit->status) }}</span></p>
    </div>

    {{-- ✅ رفع صورة جديدة --}}
    @if ($unit->status === 'cleaning')
        <form action="{{ route('admin.units.images.upload', $unit) }}" method="POST" enctype="multipart/form-data" class="mb-8 bg-white rounded-xl shadow p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.upload_image') }}</label>
                <input type="file" name="image" accept="image/*" required class="block w-full border border-gray-300 rounded px-3 py-2">
                @error('image')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                {{ __('messages.upload') }}
            </button>
        </form>
    @else
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-6 text-sm">
            {{ __('messages.unit_not_in_cleaning_status') }}
        </div>
    @endif

    {{-- ✅ عرض الصور --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($images as $image)
            <div class="relative group rounded overflow-hidden shadow hover:shadow-lg transition">
                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-40 object-cover">
                
                <form action="{{ route('admin.units.images.delete', $image) }}" method="POST" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow hover:bg-red-700">
                        &times;
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
