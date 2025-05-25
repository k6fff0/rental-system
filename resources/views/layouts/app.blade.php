<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <style>[x-cloak] { display: none !important; }</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ settings()->app_name }}</title>
    @if (settings()->favicon)
    <link rel="icon" href="{{ asset('storage/' . ltrim(settings()->favicon, '/')) }}" type="image/x-icon">
    @endif
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- 🔘 الوضع الليلي - اللغة - الحساب --}}
        <div class="flex justify-end items-center px-4 py-2 bg-white dark:bg-gray-800 shadow text-sm relative z-50">
            <div class="flex items-center gap-3">

                {{-- 🌙 الوضع الليلي --}}
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:scale-105 transition">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>

                {{-- 👤 الحساب --}}
@auth
    @php
        $user = auth()->user();
        $hasSuperAdmin = false;

        try {
            $hasSuperAdmin = $user && $user->hasPermissionTo('super-admin');
        } catch (\Throwable $e) {
            $hasSuperAdmin = false;
        }
    @endphp

    <div x-data="{ open: false }" class="relative" @click.away="open = false">
        <button @click="open = !open"
                class="flex items-center gap-2 px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5.121 17.804A9 9 0 1118.88 6.197M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-sm font-medium hidden sm:inline">{{ $user->name }}</span>
        </button>

        <div x-show="open"
             class="absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-[9999]"
             x-transition>
            <div class="py-1 text-sm">
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    🧑 {{ __('Profile') }}
                </a>

                @if ($hasSuperAdmin && Route::has('admin.system.owner'))
                    <a href="{{ route('admin.system.owner') }}"
                       class="block px-4 py-2 text-red-700 dark:text-red-400 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600">
                        🛡️ لوحة مالك النظام
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                        🔓 {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endauth

                {{-- 🌐 اللغة --}}
                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                    <button @click="open = !open" type="button"
                            class="inline-flex justify-center items-center px-3 py-2 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none transition">
                        🌐 {{ strtoupper(app()->getLocale()) }}
                        <svg class="-mr-1 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 7l3-3 3 3m0 6l-3 3-3-3"/>
                        </svg>
                    </button>

                    <div x-show="open"
                         class="absolute right-0 mt-2 w-28 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-[9999]"
                         x-transition>
                        <div class="py-1 text-sm">
                            <a href="{{ route('lang.switch', ['lang' => 'en', 'redirect' => url()->full()]) }}"
                               class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ app()->getLocale() === 'en' ? 'font-bold' : '' }}">
                                🇬🇧 English
                            </a>
                            <a href="{{ route('lang.switch', ['lang' => 'ar', 'redirect' => url()->full()]) }}"
                               class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ app()->getLocale() === 'ar' ? 'font-bold' : '' }}">
                                🇸🇦 عربي
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ✅ قائمة التنقل --}}
        @include('layouts.navigation')

        {{-- ✅ الهيدر --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- ✅ محتوى الصفحة --}}
        <main class="py-6">
            @if (session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 2000)"
                     class="max-w-4xl mx-auto mb-6 px-4 transition-opacity duration-500"
                     x-transition:leave="opacity-0">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow dark:bg-green-800 dark:border-green-600 dark:text-green-100" role="alert">
                        <strong class="font-bold">{{ __('messages.success') }}:</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- ✅ مودال عام --}}
    <div id="globalModal" x-data="{ show: false, html: '' }" x-cloak>
        <div x-show="show"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
             x-transition.opacity>
            <div @click.away="show = false"
                 class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 max-w-3xl w-full mx-4 sm:mx-0 rounded-lg shadow-lg p-6 relative z-50 overflow-y-auto max-h-[90vh]"
                 x-transition>
                <button @click="show = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 8.586l4.95-4.95 1.414 1.414L11.414 10l4.95 4.95-1.414 1.414L10 11.414l-4.95 4.95-1.414-1.414L8.586 10 3.636 5.05l1.414-1.414L10 8.586z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-html="html"></div>
            </div>
        </div>
    </div>

    {{-- ✅ السكريبتات --}}
    @stack('scripts')
</body>
</html>
