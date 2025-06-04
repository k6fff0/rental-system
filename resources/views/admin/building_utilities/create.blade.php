@extends('layouts.app')

@section('title', __('messages.add_utility'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-4xl mx-auto">
        {{-- العنوان --}}
        <div class="mb-8 flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.add_utility') }}</h1>
        </div>

        {{-- الفورم --}}
        <form action="{{ route('admin.building-utilities.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-md space-y-6">
            @csrf

            {{-- صف يحتوي على المبنى ونوع المرفق --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- المبنى --}}
                <div>
                    <label for="building_id" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.building_name') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="building_id" id="building_id" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">{{ __('messages.choose_building') }}</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('building_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- نوع المرفق --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.utility_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">{{ __('messages.choose_type') }}</option>
                        <option value="electricity" {{ old('type') == 'electricity' ? 'selected' : '' }}>
                            {{ __('messages.electricity') }}
                        </option>
                        <option value="water" {{ old('type') == 'water' ? 'selected' : '' }}>
                            {{ __('messages.water') }}
                        </option>
                        <option value="internet" {{ old('type') == 'internet' ? 'selected' : '' }}>
                            {{ __('messages.internet') }}
                        </option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- الرقم / الكود --}}
            <div>
                <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('messages.utility_value') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" name="value" id="value" required
                       value="{{ old('value') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                @error('value')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- صف يحتوي على اسم المالك ورقم الهوية --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- اسم المالك --}}
                <div>
                    <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.owner_name') }}
                    </label>
                    <input type="text" name="owner_name" id="owner_name"
                           value="{{ old('owner_name') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>

                {{-- رقم الهوية --}}
                <div>
                    <label for="owner_id_number" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('messages.owner_id') }}
                    </label>
                    <input type="text" name="owner_id_number" id="owner_id_number"
                           value="{{ old('owner_id_number') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>
            </div>

            {{-- رفع صور الهوية --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    {{ __('messages.owner_id_image') }}
                </label>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- الوجه الأمامي للهوية --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition-colors duration-200">
                        <input type="file" name="owner_id_image[]" id="front_id_image" accept="image/*" class="hidden" required>
                        <label for="front_id_image" class="cursor-pointer flex flex-col items-center justify-center h-full">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ __('messages.front_id_image') }}</span>
                            <span class="text-xs text-gray-500 mt-1">{{ __('messages.upload_front_id') }}</span>
                            <div id="front_preview" class="mt-2 hidden">
                                <img src="" alt="Front ID Preview" class="max-h-32 mx-auto rounded-lg">
                            </div>
                        </label>
                    </div>

                    {{-- الوجه الخلفي للهوية --}}
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition-colors duration-200">
                        <input type="file" name="owner_id_image[]" id="back_id_image" accept="image/*" class="hidden" required>
                        <label for="back_id_image" class="cursor-pointer flex flex-col items-center justify-center h-full">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ __('messages.back_id_image') }}</span>
                            <span class="text-xs text-gray-500 mt-1">{{ __('messages.upload_back_id') }}</span>
                            <div id="back_preview" class="mt-2 hidden">
                                <img src="" alt="Back ID Preview" class="max-h-32 mx-auto rounded-lg">
                            </div>
                        </label>
                    </div>
                </div>
                @error('owner_id_image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- الملاحظات --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('messages.notes') }}
                </label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">{{ old('notes') }}</textarea>
            </div>

            {{-- زر الحفظ --}}
            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // معاينة الصور قبل الرفع
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const previewImg = preview.querySelector('img');

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    setupImagePreview('front_id_image', 'front_preview');
    setupImagePreview('back_id_image', 'back_preview');
});
</script>
@endsection