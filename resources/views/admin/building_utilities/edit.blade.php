@extends('layouts.app')

@section('title', __('messages.edit_utility'))

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ✅ العنوان مع أيقونة --}}
    <div class="mb-8 flex items-center">
        <div class="bg-blue-100 p-3 rounded-full mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">
            {{ __('messages.edit_utility') }}
        </h1>
    </div>

    {{-- ✅ الفورم مع تصميم جميل --}}
    <form action="{{ route('admin.building-utilities.update', $buildingUtility->id) }}"
          method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded-xl shadow-lg space-y-6 border border-gray-100">
        @csrf
        @method('PUT')

        {{-- شبكة الأعمدة --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- المبنى --}}
            <div class="space-y-2">
                <label for="building_id" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ __('messages.building_name') }} <span class="text-red-500 ml-1">*</span>
                </label>
                <select name="building_id" id="building_id" required 
                        class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" {{ $buildingUtility->building_id == $building->id ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- نوع المرفق --}}
            <div class="space-y-2">
                <label for="type" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    {{ __('messages.utility_type') }} <span class="text-red-500 ml-1">*</span>
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

            {{-- الرقم / الكود --}}
            <div class="space-y-2">
                <label for="value" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    {{ __('messages.utility_value') }} <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="text" name="value" id="value" value="{{ $buildingUtility->value }}"
                       required class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>

            {{-- اسم المالك --}}
            <div class="space-y-2">
                <label for="owner_name" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('messages.owner_name') }}
                </label>
                <input type="text" name="owner_name" id="owner_name"
                       value="{{ $buildingUtility->owner_name }}"
                       class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>

            {{-- رقم الهوية --}}
            <div class="space-y-2">
                <label for="owner_id_number" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    {{ __('messages.owner_id') }}
                </label>
                <input type="text" name="owner_id_number" id="owner_id_number"
                       value="{{ $buildingUtility->owner_id_number }}"
                       class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            </div>
        </div>

        {{-- صور الهوية --}}
        <div class="space-y-4">
            <div class="space-y-2">
                <label for="owner_id_image" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('messages.owner_id_image') }}
                </label>
                <div class="flex items-center justify-center w-full">
                    <label for="owner_id_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">
                                <span class="font-semibold">{{ __('messages.click_to_upload') }}</span> {{ __('messages.or_drag_drop') }}
                            </p>
                        </div>
                        <input id="owner_id_image" name="owner_id_image[]" type="file" multiple class="hidden">
                    </label>
                </div>
            </div>

            @php
                $images = json_decode($buildingUtility->owner_id_image, true) ?? [];
            @endphp

            @if (count($images))
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($images as $img)
                        <div class="relative group border rounded-lg overflow-hidden bg-gray-50 hover:shadow-md transition-shadow duration-200">
                            <a href="{{ asset('storage/' . $img) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $img) }}"
                                     class="h-32 w-full object-contain bg-white p-2">
                            </a>

                            {{-- زر الحذف --}}
							@method('DELETE')
                            <form method="POST"
                              action="{{ route('admin.building-utilities.image.delete', $buildingUtility->id) }}">
                              @csrf
                               <input type="hidden" name="image" value="{{ $img }}">
                               <button type="submit" ...>✕</button>
                            </form>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 bg-gray-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-500 mt-2">{{ __('messages.no_images_uploaded') }}</p>
                </div>
            @endif
        </div>

        {{-- الملاحظات --}}
        <div class="space-y-2">
            <label for="notes" class="block text-sm font-medium text-gray-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ __('messages.notes') }}
            </label>
            <textarea name="notes" id="notes" rows="4"
                      class="w-full mt-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm">{{ $buildingUtility->notes }}</textarea>
        </div>

        {{-- أزرار الحفظ والإلغاء --}}
        <div class="flex items-center justify-end space-x-3 space-x-reverse pt-4">
            <a href="{{ route('admin.building-utilities.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                {{ __('messages.cancel') }}
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                {{ __('messages.update') }}
            </button>
        </div>
    </form>
</div>
@endsection