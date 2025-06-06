@extends('layouts.app')

@section('title', __('messages.edit_utility'))

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">


        {{-- ✅ عنوان الصفحة وزر العودة --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            {{-- 🔵 عنوان الصفحة مع أيقونة --}}
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ __('messages.edit_utility') }}
                </h1>
            </div>

            {{-- 🔙 زر العودة --}}
            <a href="{{ route('admin.building-utilities.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition">

                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}"
                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>

                {{ __('messages.back_to_utilities') }}
            </a>

        </div>

        {{-- ✅ فورم التعديل --}}
        <form action="{{ route('admin.building-utilities.update', $buildingUtility->id) }}" method="POST"
            enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-lg space-y-6 border border-gray-100">
            @csrf
            @method('PUT')

            {{-- الحقول --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- المبنى --}}
                <div class="space-y-2">
                    <label for="building_id" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.building_name') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="building_id" id="building_id" required
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"
                                {{ $buildingUtility->building_id == $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- نوع المرفق --}}
                <div class="space-y-2">
                    <label for="type" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.utility_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="electricity" {{ $buildingUtility->type == 'electricity' ? 'selected' : '' }}>
                            {{ __('messages.electricity') }}
                        </option>
                        <option value="water" {{ $buildingUtility->type == 'water' ? 'selected' : '' }}>
                            {{ __('messages.water') }}
                        </option>
                        <option value="internet" {{ $buildingUtility->type == 'internet' ? 'selected' : '' }}>
                            {{ __('messages.internet') }}
                        </option>
                    </select>
                </div>

                {{-- الكود --}}
                <div class="space-y-2">
                    <label for="value" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.utility_value') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="value" id="value" value="{{ old('value', $buildingUtility->value) }}"
                        required
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>

                {{-- اسم المالك --}}
                <div class="space-y-2">
                    <label for="owner_name" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.owner_name') }}
                    </label>
                    <input type="text" name="owner_name" id="owner_name"
                        value="{{ old('owner_name', $buildingUtility->owner_name) }}"
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>

                {{-- رقم الهوية --}}
                <div class="space-y-2">
                    <label for="owner_id_number" class="block text-sm font-medium text-gray-700">
                        {{ __('messages.owner_id') }}
                    </label>
                    <input type="text" name="owner_id_number" id="owner_id_number"
                        value="{{ old('owner_id_number', $buildingUtility->owner_id_number) }}"
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                </div>
            </div>

            {{-- رفع صور جديدة --}}
            <div class="space-y-2">
                <label for="owner_id_image" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.owner_id_image') }}
                </label>
                <div class="flex items-center justify-center w-full">
                    <label for="owner_id_image"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">
                                <span class="font-semibold">{{ __('messages.click_to_upload') }}</span>
                                {{ __('messages.or_drag_drop') }}
                            </p>
                        </div>
                        <input id="owner_id_image" name="owner_id_image[]" type="file" multiple class="hidden">

                    </label>
                </div>

                @error('owner_id_image')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- زر الحفظ والإلغاء --}}
            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('admin.building-utilities.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    {{ __('messages.save_changes') }}
                </button>
            </div>
        </form>

        {{-- ✅ صور الهوية الحالية + الحذف (خارج الفورم) --}}
        @php
            $images = [];
            if (!empty($buildingUtility->owner_id_image)) {
                $decoded = json_decode($buildingUtility->owner_id_image, true);
                $images = is_array($decoded) ? $decoded : [];
            }
        @endphp

        @if (count($images) > 0)
            <div class="mt-10 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($images as $img)
                    @if (!empty($img))
                        <div
                            class="relative group border rounded-lg overflow-hidden bg-gray-50 hover:shadow-md transition-shadow duration-200">
                            <a href="{{ asset('storage/' . $img) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $img) }}"
                                    class="h-32 w-full object-contain bg-white p-2">
                            </a>
                            <form method="POST"
                                action="{{ route('admin.building-utilities.image.delete', $buildingUtility->id) }}"
                                class="absolute top-1 right-1 z-10">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="image" value="{{ $img }}">
                                <button type="submit"
                                    class="text-red-600 text-sm bg-white rounded-full p-1 shadow hover:bg-red-100 transition"
                                    onclick="return confirm('{{ __('messages.are_you_sure_delete_image') }}')">
                                    ✕
                                </button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-4 bg-gray-50 rounded-lg mt-6">
                <svg class="h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-sm text-gray-500 mt-2">{{ __('messages.no_images_uploaded') }}</p>
            </div>
        @endif

    </div>
@endsection
