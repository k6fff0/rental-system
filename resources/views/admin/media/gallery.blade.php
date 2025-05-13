@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.image_gallery') }}</h2>

    @if (count($images) === 0)
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded shadow">
            {{ __('messages.no_images_found') }}
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($images as $image)
                <div class="bg-white rounded shadow hover:shadow-lg transition overflow-hidden">
                    <img src="{{ asset('storage/images/' . $image) }}"
                         alt="{{ $image }}"
                         class="w-full h-48 object-cover rounded-t">

                    <div class="p-2 text-sm text-gray-600 truncate text-center">
                        {{ $image }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
