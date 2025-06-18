<x-guest-layout>
    <div class="h-[1000px] w-[400px] flex flex-col justify-center bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
        <div class="relative w-full max-w-sm sm:max-w-md lg:max-w-2xl mx-auto"> <!-- Increased max width for larger screens -->
            <!-- Language Selector -->
            <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} z-50 -mt-4">
                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                    <button @click="open = !open" type="button"
                        class="inline-flex justify-center items-center px-3 py-2 bg-white/90 backdrop-blur-sm text-sm font-medium text-gray-700 border border-gray-200 rounded-lg shadow-sm hover:bg-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <span class="text-base mr-1">🌐</span>
                        <span class="font-semibold">{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} h-4 w-4 transition-transform duration-200" 
                             :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" 
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-40 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden z-60">
                        <div class="py-1">
                            <a href="{{ route('lang.switch', ['lang' => 'en', 'redirect' => url()->full()]) }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150 {{ app()->getLocale() === 'en' ? 'bg-indigo-50 text-indigo-700 font-semibold' : '' }}">
                                <span class="text-lg mr-3">🇬🇧</span>
                                <span>English</span>
                                @if(app()->getLocale() === 'en')
                                    <svg class="ml-auto h-4 w-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>
                            <a href="{{ route('lang.switch', ['lang' => 'ar', 'redirect' => url()->full()]) }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150 {{ app()->getLocale() === 'ar' ? 'bg-indigo-50 text-indigo-700 font-semibold' : '' }}">
                                <span class="text-lg mr-3">🇸🇦</span>
                                <span>عربي</span>
                                @if(app()->getLocale() === 'ar')
                                    <svg class="ml-auto h-4 w-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Container -->
            <div class="mt-8 space-y-8">
                <!-- Header Section -->
                <div class="text-center">
                    <!-- Company Logo -->
                   <div class="mx-auto rounded-full shadow-xl mb-6 ring-4 ring-white overflow-hidden w-28 h-28 sm:w-32 sm:h-32 bg-white flex items-center justify-center">
    <img src="{{ asset('storage/' . settings()->app_logo) }}"
         alt="{{ __('messages.company_name') }}"
         class="w-full h-full object-contain p-2">
</div>

                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                        {{ __('messages.login_title') }}
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 px-4">
                        {{ __('messages.login_subtitle') }}
                    </p>
                </div>

                <!-- Login Card - Now wider on desktop -->
                <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl border border-white/30 p-6 sm:p-8 mx-4 lg:mx-0 lg:w-full">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />
                    
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email or Phone Input -->
                        <div class="space-y-2">
                            <x-input-label for="login" :value="__('messages.email_or_phone')" 
                                         class="text-gray-700 font-semibold text-sm" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="login" 
                                    class="block w-full {{ app()->getLocale() == 'ar' ? 'pr-12 text-right' : 'pl-12' }} py-4 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-gray-50/70 hover:bg-white focus:bg-white text-base" 
                                    type="text" 
                                    name="login" 
                                    :value="old('login')" 
                                    required 
                                    autofocus 
                                    autocomplete="username"
                                    :placeholder="__('messages.login_placeholder')" />
                            </div>
                            <x-input-error :messages="$errors->get('login')" class="mt-2 text-sm" />
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-2">
                            <x-input-label for="password" :value="__('messages.password')" 
                                         class="text-gray-700 font-semibold text-sm" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="password" 
                                    class="block w-full {{ app()->getLocale() == 'ar' ? 'pr-12 pl-12 text-right' : 'pl-12 pr-12' }} py-4 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-gray-50/70 hover:bg-white focus:bg-white text-base"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="current-password"
                                    :placeholder="__('messages.password_placeholder')" />
                                <button type="button" 
                                        onclick="togglePassword()" 
                                        class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4' }} flex items-center focus:outline-none">
                                    <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-indigo-500 transition-colors duration-200" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition duration-200" 
                                    name="remember">
                                <label for="remember_me" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} block text-sm text-gray-700 select-none cursor-pointer">
                                    {{ __('messages.remember_me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-200 hover:underline focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded" 
                                       href="{{ route('password.request') }}">
                                        {{ __('messages.forgot_password') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="pt-6">
                            <button type="submit" 
                                    class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-base font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="absolute {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} inset-y-0 flex items-center">
                                    <svg class="h-5 w-5 text-indigo-200 group-hover:text-white transition duration-200" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="{{ app()->getLocale() == 'ar' ? 'M13 16l4-4m0 0l-4-4m4 4H3' : 'M11 16l-4-4m0 0l4-4m-4 4h14' }}"/>
                                    </svg>
                                </span>
                                {{ __('messages.login_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
<footer class="mt-8 text-center">
    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 mx-4 lg:mx-0 border border-white/30 text-[11px] text-gray-600 leading-relaxed">
        <p class="mb-1">
            © {{ date('Y') }} {{ config('app.name', 'شركتك') }} — {{ __('messages.footer_text') }}
        </p>
        <p>
            {{ __('messages.privacy_terms_note') }}
            <a href="https://wa.me/971503660507" target="_blank" class="text-indigo-600 hover:underline font-medium">
                Amr Mohammed 
            </a>
        </p>
    </div>
</footer>

        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            const inputs = form.querySelectorAll('input[required]');

            // Add loading state to submit button
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('messages.logging_in') ?? 'جاري تسجيل الدخول...' }}
                `;
            });

            // Real-time validation feedback
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                        this.classList.remove('border-gray-300', 'focus:ring-indigo-500', 'focus:border-transparent');
                    } else {
                        this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                        this.classList.add('border-gray-300', 'focus:ring-indigo-500', 'focus:border-transparent');
                    }
                });
            });

            // Auto-save language preference
            const languageButtons = document.querySelectorAll('a[href*="lang.switch"]');
            languageButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const url = new URL(this.href);
                    const lang = url.searchParams.get('lang');
                    localStorage.setItem('preferred_language', lang);
                });
            });
        });
    </script>

    <style>
        /* Enhanced RTL Support */
        [dir="rtl"] {
            direction: rtl;
        }
        
        [dir="rtl"] .text-left {
            text-align: right !important;
        }
        
        [dir="rtl"] .text-right {
            text-align: left !important;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .backdrop-blur-md {
                backdrop-filter: blur(8px);
            }
            
            /* Ensure proper touch targets */
            button, a, input[type="checkbox"] {
                min-height: 44px;
                min-width: 44px;
            }
            
            input[type="checkbox"] {
                transform: scale(1.2);
            }
        }

        /* Desktop optimizations */
        @media (min-width: 1024px) {
            .lg\:max-w-2xl {
                max-width: 42rem !important; /* Wider container on desktop */
            }
            
            .lg\:w-full {
                width: 100% !important; /* Full width elements */
            }
            
            .lg\:mx-0 {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }

        /* Custom focus styles */
        .focus-visible:focus {
            outline: 2px solid theme('colors.indigo.500');
            outline-offset: 2px;
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading animation for better UX */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    <!-- Alpine.js for enhanced interactivity -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-guest-layout>