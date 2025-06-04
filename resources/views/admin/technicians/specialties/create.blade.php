@extends('layouts.app')

@section('title', isset($specialty) ? __('messages.edit_specialty') : __('messages.add_specialty'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            {{-- Header --}}
            <div class="flex items-center justify-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">
                    {{ isset($specialty) ? __('messages.edit_specialty') : __('messages.add_specialty') }}
                </h1>
            </div>

            <form method="POST" action="{{ isset($specialty) ? route('admin.technicians.specialties.update', $specialty->id) : route('admin.technicians.specialties.store') }}" class="space-y-6">
                @csrf
                @if(isset($specialty))
                    @method('PUT')
                @endif

                {{-- Specialty Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.specialty_name') }}
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $specialty->name ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Specialty Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.specialty_type') }}
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="is_main" value="1" {{ old('is_main', $specialty->is_main ?? 1) == 1 ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block font-medium text-gray-800">{{ __('messages.main_specialty') }}</span>
                                <span class="block text-xs text-gray-500 mt-1">{{ __('messages.main_specialty_desc') }}</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="is_main" value="0" {{ old('is_main', $specialty->is_main ?? 1) == 0 ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block font-medium text-gray-800">{{ __('messages.sub_specialty') }}</span>
                                <span class="block text-xs text-gray-500 mt-1">{{ __('messages.sub_specialty_desc') }}</span>
                            </div>
                        </label>
                    </div>
                    @error('is_main')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Parent Specialty (for sub-specialties only) --}}
                <div id="parent_section" class="transition-all duration-300">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.parent_specialty') }}
                    </label>
                    <select name="parent_id" id="parent_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('parent_id') border-red-500 @enderror">
                        <option value="">— {{ __('messages.select_main_specialty') }} —</option>
                        @foreach($mainSpecialties as $main)
                            <option value="{{ $main->id }}" {{ old('parent_id', $specialty->parent_id ?? '') == $main->id ? 'selected' : '' }}>
                                {{ $main->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4">
                    <a href="{{ route('admin.technicians.specialties.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 text-center">
                        {{ __('messages.cancel') }}
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        {{ isset($specialty) ? __('messages.update') : __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isMainRadios = document.querySelectorAll('input[name="is_main"]');
    const parentSection = document.getElementById('parent_section');

    function toggleParentSection() {
        const isMain = document.querySelector('input[name="is_main"]:checked').value;
        if (isMain == 0) {
            parentSection.style.opacity = '1';
            parentSection.style.height = 'auto';
            parentSection.style.visibility = 'visible';
            parentSection.style.marginBottom = '1.5rem';
        } else {
            parentSection.style.opacity = '0';
            parentSection.style.height = '0';
            parentSection.style.visibility = 'hidden';
            parentSection.style.marginBottom = '0';
        }
    }

    // Initialize on load
    toggleParentSection();
    
    // Add event listeners
    isMainRadios.forEach(radio => {
        radio.addEventListener('change', toggleParentSection);
    });
});
</script>
@endsection