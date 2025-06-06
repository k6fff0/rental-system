@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow mt-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.upload_image') }}</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.image.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="image"
                    class="block text-sm font-medium text-gray-700">{{ __('messages.choose_image') }}</label>
                <input type="file" name="image" id="image" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                {{ __('messages.upload') }}
            </button>
        </form>
    </div>
@endsection
