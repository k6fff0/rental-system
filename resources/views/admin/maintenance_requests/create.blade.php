@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300" 
         dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        
        <div class="max-w-lg mx-auto">
            {{-- Header Section - Compact for Mobile --}}
            <div class="text-center mb-4 px-2">
                <div class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-xl mb-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                    {{ __('messages.add_maintenance_request') }}
                </h1>
                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    {{ __('messages.fill_required_fields') }}
                </p>
            </div>

            {{-- Alert Messages - Mobile Optimized --}}
            @if (session('error'))
                <div class="mb-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-700 dark:text-red-200 text-sm leading-relaxed">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-700 dark:text-green-200 text-sm leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Main Form Card - Mobile First Design --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 transition-colors duration-300 mx-2">
                <form action="{{ route('admin.maintenance_requests.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="p-3 space-y-4">
                        {{-- Smart Unit Search - Mobile Optimized --}}
                        <div class="space-y-2">
                            <label for="unit_id" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="mr-1">{{ __('messages.unit') }}</span>
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <select name="unit_id" id="unit_id" required
                                class="select2-unit w-full px-3 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">{{ __('messages.select_unit') }}</option>
                            </select>
                            @error('unit_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Issue Type - Mobile Optimized --}}
                        <div class="space-y-2">
                            <label for="sub_specialty_id" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="mr-1">{{ __('messages.issue_type') }}</span>
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <select name="sub_specialty_id" id="sub_specialty_id" required
                                class="w-full px-3 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option value="">{{ __('messages.select_issue_type') }}</option>
                                @foreach ($subSpecialties as $subtask)
                                    <option value="{{ $subtask->id }}" {{ old('sub_specialty_id') == $subtask->id ? 'selected' : '' }}>
                                        {{ $subtask->name }} ({{ $subtask->parent?->name ?? __('messages.unspecified') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_specialty_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description - Mobile Optimized --}}
                        <div class="space-y-2">
                            <label for="description" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="mr-1">{{ __('messages.description') }}</span>
                                <span class="text-red-500 text-xs">*</span>
                            </label>
                            <textarea name="description" id="description" rows="4" required
                                placeholder="{{ __('messages.describe_problem') }}"
                                class="w-full px-3 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Contact Information Section - Mobile First --}}
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3 space-y-3">
                            <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 flex items-center">
                                <svg class="w-4 h-4 ml-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="mr-1">{{ __('messages.contact_info') }}</span>
                            </h3>
                            
                            {{-- Extra Phone - Full Width on Mobile --}}
                            <div class="space-y-2">
                                <label for="extra_phone" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('messages.extra_contact_number') }}
                                </label>
                                <input type="tel" name="extra_phone" id="extra_phone"
                                    value="{{ old('extra_phone') }}"
                                    placeholder="05xxxxxxxx"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            </div>

                            {{-- WhatsApp Checkbox - Better Mobile Layout --}}
                            <div class="flex items-center">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_whatsapp" id="is_whatsapp" value="1"
                                        {{ old('is_whatsapp') ? 'checked' : '' }}
                                        class="w-4 h-4 text-green-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-green-500 dark:focus:ring-green-600 focus:ring-2">
                                    <span class="mr-2 text-sm text-gray-700 dark:text-gray-300 flex items-center">
                                        <svg class="w-4 h-4 text-green-500 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.787"/>
                                        </svg>
                                        <span class="mr-1">{{ __('messages.is_whatsapp') }}</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- Emergency Section - Mobile First --}}
                        @can('create emergency request')
                        <div class="space-y-2">
                            <label class="flex items-start cursor-pointer bg-red-50 dark:bg-red-900/20 p-3 rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900/30 transition-all duration-200">
                                <input type="checkbox" name="is_emergency" value="1" 
                                    {{ old('is_emergency') ? 'checked' : '' }}
                                    class="w-4 h-4 mt-1 text-red-600 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-red-500 dark:focus:ring-red-600 focus:ring-2 flex-shrink-0">
                                <div class="mr-3">
                                    <span class="text-red-600 dark:text-red-400 font-medium text-sm flex items-center">
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="mr-1">{{ __('messages.is_emergency') }}</span>
                                    </span>
                                    <p class="text-xs text-red-500 dark:text-red-400 mt-1 leading-relaxed">{{ __('messages.emergency_note') }}</p>
                                </div>
                            </label>
                        </div>
                        @endcan

                        {{-- Audio Note Section - Mobile Optimized --}}
                        <div class="space-y-3">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                <span class="text-lg ml-1">🎤</span>
                                <span>{{ __('messages.audio_note') ?? 'ملاحظة صوتية' }}</span>
                            </label>

                            {{-- Recording Controls - Mobile First Layout --}}
                            <div class="flex flex-col gap-3">
                                <div class="flex gap-2">
                                    <button type="button" id="startRecording"
                                        class="flex-1 px-4 py-3 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                        <span class="text-base ml-1">🎙️</span>
                                        بدء التسجيل
                                    </button>
                                    <button type="button" id="stopRecording"
                                        class="flex-1 px-4 py-3 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors duration-200 hidden flex items-center justify-center">
                                        <span class="text-base ml-1">🛑</span>
                                        إيقاف التسجيل
                                    </button>
                                </div>

                                {{-- Audio Preview - Full Width --}}
                                <audio id="audioPreview" controls class="hidden w-full h-10"></audio>
                                <input type="hidden" name="audio_data" id="audioData">
                            </div>
                        </div>

                        {{-- Image Upload - Mobile Optimized --}}
                        <div class="space-y-2">
                            <label for="image" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="mr-1">{{ __('messages.image') }}</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="image" id="image" 
                                    class="hidden" 
                                    accept="image/*"
                                    onchange="showFileName(this)">
                                <label for="image" class="block w-full cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 active:scale-95">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-blue-600 dark:text-blue-400">{{ __('messages.upload_image') }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF حتى 10MB</p>
                                        <p id="file-name" class="text-xs text-blue-600 dark:text-blue-400 mt-2 hidden font-medium"></p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Form Actions - Mobile Optimized --}}
                    <div class="bg-gray-50 dark:bg-gray-700/30 px-3 py-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col gap-3">
                            {{-- Submit Button - Full Width, Primary --}}
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all duration-200 active:scale-95">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                {{ __('messages.save') }}
                            </button>
                            
                            {{-- Back Button - Secondary --}}
                            <a href="{{ url()->previous() }}"
                                class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm active:scale-95">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('messages.back') }}
                            </a>                           
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Enhanced JavaScript for Select2 Search --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Mobile-First Select2 Dark Mode CSS --}}
    <style>
        /* Mobile-First Select2 Styling */
        .select2-container--default .select2-selection--single {
            background-color: white !important;
            border: 1px solid rgb(209 213 219) !important;
            border-radius: 0.5rem !important;
            height: 44px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
        }
        
        .dark .select2-container--default .select2-selection--single {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
            color: rgb(249 250 251) !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: rgb(17 24 39) !important;
            line-height: 28px !important;
            padding-left: 0 !important;
            padding-right: 25px !important;
        }
        
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: rgb(249 250 251) !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
            right: 8px !important;
        }
        
        .select2-dropdown {
            border: 1px solid rgb(209 213 219) !important;
            border-radius: 0.5rem !important;
            background-color: white !important;
            font-size: 14px !important;
        }
        
        .dark .select2-dropdown {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
        }
        
        .select2-container--default .select2-results__option {
            padding: 10px 12px !important;
            color: rgb(17 24 39) !important;
            line-height: 1.4 !important;
        }
        
        .dark .select2-container--default .select2-results__option {
            color: rgb(249 250 251) !important;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: rgb(59 130 246) !important;
            color: white !important;
        }
        
        .select2-search--dropdown .select2-search__field {
            border: 1px solid rgb(209 213 219) !important;
            border-radius: 0.5rem !important;
            padding: 8px 12px !important;
            background-color: white !important;
            color: rgb(17 24 39) !important;
            font-size: 14px !important;
            margin: 8px !important;
            width: calc(100% - 16px) !important;
        }
        
        .dark .select2-search--dropdown .select2-search__field {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
            color: rgb(249 250 251) !important;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: rgb(59 130 246) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }
        
        .select2-container {
            width: 100% !important;
        }

        /* Mobile-specific improvements */
        @media (max-width: 640px) {
            .select2-dropdown {
                width: 100% !important;
                max-height: 200px !important;
            }
            
            .select2-results__options {
                max-height: 150px !important;
            }
        }

        /* Improve touch targets for mobile */
        .select2-container--default .select2-results__option {
            min-height: 44px !important;
            display: flex !important;
            align-items: center !important;
        }
    </style>

    <script>
        function showFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameElement.textContent = '✓ ' + input.files[0].name;
                fileNameElement.classList.remove('hidden');
            } else {
                fileNameElement.classList.add('hidden');
            }
        }

        // Initialize Select2 with AJAX search - Mobile Optimized
        $(document).ready(function() {
            $('.select2-unit').select2({
                placeholder: '{{ app()->getLocale() == "ar" ? "ابحث باسم المبنى أو رقم الغرفة..." : "Search by building name or unit number..." }}',
                dir: '{{ app()->getLocale() == "ar" ? "rtl" : "ltr" }}',
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                ajax: {
                    url: '{{ route('admin.units.search') }}',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {
                            q: params.term,
                            search_type: 'both',
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results || data,
                            pagination: {
                                more: data.pagination ? data.pagination.more : false
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                language: {
                    inputTooShort: function() {
                        return '{{ app()->getLocale() == "ar" ? "اكتب حرف واحد على الأقل للبحث" : "Please enter 1 or more characters" }}';
                    },
                    noResults: function() {
                        return '{{ app()->getLocale() == "ar" ? "لا توجد وحدات بهذا الاسم أو الرقم" : "No units found with this name or number" }}';
                    },
                    searching: function() {
                        return '{{ app()->getLocale() == "ar" ? "جاري البحث..." : "Searching..." }}';
                    }
                },
                templateResult: function(option) {
                    if (option.loading) {
                        return option.text;
                    }
                    
                    var $result = $('<div class="flex items-center gap-2 py-1"></div>');
                    $result.append('<svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>');
                    
                    if (option.text) {
                        var parts = option.text.split(' - ');
                        if (parts.length >= 2) {
                            $result.append('<div class="flex flex-col min-w-0"><span class="font-medium text-gray-900 dark:text-gray-100 truncate">' + parts[0] + '</span><span class="text-xs text-gray-500 dark:text-gray-400 truncate">' + parts[1] + '</span></div>');
                        } else {
                            $result.append('<span class="font-medium truncate">' + option.text + '</span>');
                        }
                    }
                    
                    return $result;
                },
                templateSelection: function(option) {
                    return option.text || option.id;
                },
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            // Handle old values
            @if(old('unit_id'))
                var oldUnitId = '{{ old('unit_id') }}';
                var oldUnitText = '{{ old('unit_text', '') }}';
                
                if (oldUnitId && oldUnitText) {
                    var newOption = new Option(oldUnitText, oldUnitId, true, true);
                    $('.select2-unit').append(newOption).trigger('change');
                }
            @endif

            // Mobile-friendly placeholder update
            $('.select2-unit').on('select2:open', function() {
                setTimeout(function() {
                    $('.select2-search__field').attr('placeholder', '{{ app()->getLocale() == "ar" ? "مثال: برج السلام أو 101" : "Example: Peace Tower or 101" }}');
                }, 100);
            });
        });

        // Audio Recording Functionality - Mobile Optimized
        let mediaRecorder;
        let audioChunks = [];

        const startBtn = document.getElementById('startRecording');
        const stopBtn = document.getElementById('stopRecording');
        const audioPreview = document.getElementById('audioPreview');
        const audioDataField = document.getElementById('audioData');

        startBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        sampleRate: 44100
                    }
                });
                
                mediaRecorder = new MediaRecorder(stream, {
                    mimeType: 'audio/webm;codecs=opus'
                });

                audioChunks = [];

                mediaRecorder.ondataavailable = e => {
                    audioChunks.push(e.data);
                };

                mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioPreview.src = audioUrl;
                    audioPreview.classList.remove('hidden');

                    // Convert to base64
                    const reader = new FileReader();
                    reader.readAsDataURL(audioBlob);
                    reader.onloadend = () => {
                        audioDataField.value = reader.result;
                    };

                    // Stop all tracks to free up the microphone
                    stream.getTracks().forEach(track => track.stop());
                };

                mediaRecorder.start();
                startBtn.classList.add('hidden');
                stopBtn.classList.remove('hidden');
                
                // Visual feedback for recording
                startBtn.style.backgroundColor = '#dc2626';
                
            } catch (err) {
                alert("حدث خطأ في الوصول إلى الميكروفون. تأكد من السماح بالوصول للميكروفون.");
                console.error('Microphone access error:', err);
            }
        });

        stopBtn.addEventListener('click', () => {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                startBtn.classList.remove('hidden');
                stopBtn.classList.add('hidden');
                startBtn.style.backgroundColor = '';
            }
        });

        // Prevent form submission while recording
        document.querySelector('form').addEventListener('submit', function(e) {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                e.preventDefault();
                alert('يرجى إيقاف التسجيل أولاً قبل إرسال النموذج');
                return false;
            }
        });

        // Auto-resize textarea on mobile
        const textarea = document.getElementById('description');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Improve mobile form experience
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to submit button
            const submitBtn = document.querySelector('button[type="submit"]');
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>جاري الحفظ...';
                submitBtn.disabled = true;
            });
        });
    </script>

@endsection