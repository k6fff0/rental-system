@extends('layouts.app')

@section('title', __('messages.edit_technician'))

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-2 px-2 sm:px-4 lg:px-8 transition-colors duration-300"
        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

        <div class="max-w-2xl mx-auto">
            {{-- Header Section - Mobile Optimized --}}
            <div class="text-center mb-4 px-2">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/50 dark:to-indigo-900/50 rounded-xl mb-3">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white leading-tight mb-1">
                    {{ __('messages.edit_technician') }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.editing_technician_data_for') }} <span
                        class="font-medium text-purple-600 dark:text-purple-400">{{ $technician->name }}</span>
                </p>
            </div>

            {{-- Alert Messages --}}
            @if ($errors->any())
                <div
                    class="mb-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            @foreach ($errors->all() as $error)
                                <p class="text-red-700 dark:text-red-200 text-sm leading-relaxed">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div
                    class="mb-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-3 mx-2">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 ml-2 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-700 dark:text-green-200 text-sm leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Main Form --}}
            <form action="{{ route('admin.technicians.update', $technician->id) }}" method="POST"
                class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mx-2 overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                @csrf
                @method('PUT')

                {{-- Form Header --}}
                <div
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-700 dark:to-indigo-700 px-4 py-3">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('messages.technician_information') }}
                    </h2>
                </div>

                <div class="p-4 space-y-6">
                    {{-- Technical Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div
                                class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-bold">1</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.technical_specialization') }}</h3>
                        </div>

                        {{-- Main Specialty --}}
                        <div class="space-y-2">
                            <label for="main_specialty_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    {{ __('messages.main_specialty') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <select name="main_specialty_id" id="main_specialty_id" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                <option value="">{{ __('messages.choose_specialty') }}</option>
                                @foreach ($mainSpecialties as $main)
                                    <option value="{{ $main->id }}"
                                        {{ old('main_specialty_id', $technician->main_specialty_id) == $main->id ? 'selected' : '' }}>
                                        {{ $main->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('main_specialty_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div
                                class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/50 rounded-full flex items-center justify-center">
                                <span class="text-yellow-600 dark:text-yellow-400 text-sm font-bold">2</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.status_and_availability') }}</h3>
                        </div>

                        {{-- Technician Status --}}
                        <div class="space-y-2">
                            <label for="technician_status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('messages.technician_status') }}
                                    <span class="text-red-500 text-xs">*</span>
                                </span>
                            </label>
                            <select name="technician_status" id="technician_status" required
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                <option value="available"
                                    {{ old('technician_status', $technician->technician_status) == 'available' ? 'selected' : '' }}>
                                    {{ __('messages.technician_status_available') }}
                                </option>
                                <option value="busy"
                                    {{ old('technician_status', $technician->technician_status) == 'busy' ? 'selected' : '' }}>
                                    {{ __('messages.technician_status_busy') }}
                                </option>
                                <option value="unavailable"
                                    {{ old('technician_status', $technician->technician_status) == 'unavailable' ? 'selected' : '' }}>
                                    {{ __('messages.technician_status_unavailable') }}
                                </option>
                            </select>
                            @error('technician_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Additional Information Section --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            <div
                                class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                <span class="text-green-600 dark:text-green-400 text-sm font-bold">3</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                {{ __('messages.additional_information') }}</h3>
                        </div>

                        {{-- Notes --}}
                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    {{ __('messages.notes') }}
                                </span>
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                placeholder="{{ __('messages.technician_notes_placeholder') }}"
                                class="w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 resize-none">{{ old('notes', $technician->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions - Mobile Optimized --}}
                <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col-reverse sm:flex-row gap-3">
                        {{-- Back Button --}}
                        <a href="{{ route('admin.technicians.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('messages.back') }}
                        </a>

                        {{-- Update Button --}}
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            {{ __('messages.save_changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Form validation and submission
            form.addEventListener('submit', function(e) {
                // Prevent double submission
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }

                // Basic form validation
                const requiredFields = form.querySelectorAll('[required]');
                let hasErrors = false;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500', 'dark:border-red-500');
                        hasErrors = true;
                    } else {
                        field.classList.remove('border-red-500', 'dark:border-red-500');
                    }
                });

                if (hasErrors) {
                    e.preventDefault();
                    showNotification('{{ __('messages.please_fill_required_fields') }}', 'error');

                    // Focus on first error field
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('messages.saving_changes') }}...
                `;

                // Re-enable button after 10 seconds as fallback
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                }, 10000);
            });

            // Real-time form validation
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('border-red-500')) {
                        validateField(this);
                    }
                });
            });

            // Field validation function
            function validateField(field) {
                const value = field.value.trim();
                const isRequired = field.hasAttribute('required');

                // Remove existing validation classes
                field.classList.remove('border-red-500', 'border-green-500', 'dark:border-red-500',
                    'dark:border-green-500');

                if (isRequired && !value) {
                    field.classList.add('border-red-500', 'dark:border-red-500');
                    return false;
                }

                // If validation passes and field has value
                if (value) {
                    field.classList.add('border-green-500', 'dark:border-green-500');
                }

                return true;
            }

            // Status change visual feedback
            const statusSelect = document.querySelector('#technician_status');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    const value = this.value;
                    const statusColors = {
                        'available': 'border-green-500 dark:border-green-500',
                        'busy': 'border-yellow-500 dark:border-yellow-500',
                        'unavailable': 'border-red-500 dark:border-red-500'
                    };

                    // Remove all status colors
                    Object.values(statusColors).forEach(colorClass => {
                        this.classList.remove(...colorClass.split(' '));
                    });

                    // Add current status color
                    if (statusColors[value]) {
                        this.classList.add(...statusColors[value].split(' '));
                    }
                });

                // Trigger initial status color
                statusSelect.dispatchEvent(new Event('change'));
            }

            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });

                // Initial resize
                textarea.style.height = textarea.scrollHeight + 'px';
            });

            // Notification system
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotification = document.querySelector('.notification');
                if (existingNotification) {
                    existingNotification.remove();
                }

                // Create notification
                const notification = document.createElement('div');
                notification.className =
                    `notification fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

                // Set colors based on type
                if (type === 'error') {
                    notification.className += ' bg-red-500 text-white';
                } else if (type === 'success') {
                    notification.className += ' bg-green-500 text-white';
                } else {
                    notification.className += ' bg-blue-500 text-white';
                }

                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            ${type === 'error' ? 
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
                                type === 'success' ?
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                            }
                        </div>
                        <div class="flex-1 text-sm font-medium">
                            ${message}
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-2 text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }, 5000);
            }

            // Mobile-specific optimizations
            if (window.innerWidth <= 768) {
                // Improve touch responsiveness on iOS
                if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                    // Prevent zoom on input focus
                    const allInputs = document.querySelectorAll('input, select, textarea');
                    allInputs.forEach(input => {
                        input.addEventListener('focus', function() {
                            if (this.style.fontSize !== '16px') {
                                this.style.fontSize = '16px';
                            }
                        });
                    });
                }

                // Add haptic feedback for mobile interactions (if supported)
                if ('vibrate' in navigator) {
                    const interactiveElements = document.querySelectorAll('button, select');
                    interactiveElements.forEach(element => {
                        element.addEventListener('click', function() {
                            navigator.vibrate(10); // Short vibration
                        });
                    });
                }
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S to save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }

                // Escape to go back
                if (e.key === 'Escape') {
                    const backButton = document.querySelector('a[href*="technicians.index"]');
                    if (backButton && confirm('{{ __('messages.exit_without_saving_changes') }}')) {
                        backButton.click();
                    }
                }
            });

            // Form section animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Animate form sections on scroll
            const sections = document.querySelectorAll('.space-y-4');
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });

            // Make notification function globally available
            window.showNotification = showNotification;

            // Show success message if updated
            @if (session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif
        });
    </script>
@endsection
