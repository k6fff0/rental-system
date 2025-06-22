<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.shortcuts_dashboard') }}</title>
    @vite(['resources/css/app.css']) 
    <link href="{{ asset('assets/fontawesome/all.min.css') }}" rel="stylesheet">

   
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

        [dir="rtl"] {
            font-family: 'Cairo', sans-serif;
        }

        [dir="ltr"] {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .dark .gradient-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glassmorphism {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* Logo animation */
        .logo-bounce {
            animation: logoBounce 2s ease-in-out infinite;
        }

        @keyframes logoBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Language dropdown improvements */
        .language-dropdown {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .language-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .language-item {
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .language-item:hover {
            transform: translateX(4px);
        }

        .language-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .language-item:hover::before {
            left: 100%;
        }

        /* Mobile responsive improvements */
        @media (max-width: 640px) {
            .company-name {
                font-size: 1rem;
            }
            
            .dashboard-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Enhanced Header with Logo and Company Name -->
    <header class="gradient-bg shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="flex justify-between items-center">
                <!-- Logo and Company Section -->
                <div class="flex items-center space-x-4 rtl:space-x-reverse animate-slide-up">
                    <!-- Logo Container -->
					<a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 lg:w-20 lg:h-20 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-lg logo-bounce">
                            <!-- Default Logo Icon -->
                                                  
                            <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 object-contain"> 
                        </div>
                    </div>

                    <!-- Company Name and Dashboard Title -->
                    <div class="flex flex-col">
                        <!-- Company Name -->
                        <h2 class="company-name text-lg sm:text-xl lg:text-2xl font-bold text-white leading-tight">
                           {{ config('app.name') }}
                        </h2>
                        </a>
                        <!-- Dashboard Title -->
                        <h1 class="text-sm sm:text-base lg:text-lg font-semibold text-blue-100 leading-tight">
                            {{ __('messages.shortcuts_dashboard') }}
                           
                        </h1>   
                        <!-- Welcome on Mobile -->
                        <div class="block md:hidden text-white font-medium text-xs">
                          {{ __('Welcome') }}, {{ Auth::user()->name ?? 'user' }}
                        </div>						
                    </div>
                </div>

                <!-- Controls Section -->
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <!-- User Welcome (Hidden on Mobile) -->
                    <div class="hidden md:block text-white font-medium text-sm lg:text-base">                       
                       {{ __('Welcome') }}, {{ Auth::user()->name ?? 'user' }}
                    </div>
                    
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" 
                        class="glassmorphism text-white p-2 sm:p-3 rounded-xl hover:bg-white hover:bg-opacity-20 transition-all duration-300 group">
                        <i class="fas fa-moon dark:hidden text-sm sm:text-base group-hover:animate-pulse"></i>
                        <i class="fas fa-sun hidden dark:block text-sm sm:text-base text-yellow-300 group-hover:animate-pulse"></i>
                    </button>

                    <!-- Language Selector with Fixed Dropdown -->
                    <div x-data="{ open: false }" class="relative z-[110]" @click.away="open = false">
                        <!-- Language Button -->
                        <button onclick="toggleLanguageDropdown()" 
                            class="glassmorphism text-white px-3 py-2 sm:px-4 sm:py-3 rounded-xl hover:bg-white hover:bg-opacity-20 transition-all duration-300 flex items-center space-x-2 rtl:space-x-reverse group">
                            <i class="fas fa-globe text-sm sm:text-base group-hover:animate-pulse"></i>
                            <span class="text-xs sm:text-sm font-medium">العربية</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="languageChevron"></i>
                        </button>

                        <!-- Language Dropdown -->
                        <div id="languageDropdown" class="language-dropdown absolute right-0 rtl:left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50">
                            <div class="py-2">
                                <!-- Arabic -->
                                <a href="{{ route('lang.switch', ['lang' => 'ar', 'redirect' => url()->full()]) }}" class="language-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-bold">
                                    <span class="text-lg mr-3 rtl:ml-3">🇸🇦</span>
                                    <div class="flex flex-col">
                                        <span class="font-semibold">العربية</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Arabic</span>
                                    </div>
                                    <i class="fas fa-check text-green-500 mr-auto rtl:ml-auto"></i>
                                </a>
                                
                                <!-- English -->
                                <a href="{{ route('lang.switch', ['lang' => 'en', 'redirect' => url()->full()]) }}" class="language-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="text-lg mr-3 rtl:ml-3">🇬🇧</span>
                                    <div class="flex flex-col">
                                        <span class="font-semibold">English</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">الإنجليزية</span>
                                    </div>
                                </a>
                                
                                <!-- Urdu -->
                                <a href="{{ route('lang.switch', ['lang' => 'ur', 'redirect' => url()->full()]) }}" class="language-item flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span class="text-lg mr-3 rtl:ml-3">🇵🇰</span>
                                    <div class="flex flex-col">
                                        <span class="font-semibold">اردو</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Urdu</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Language dropdown functionality
        function toggleLanguageDropdown() {
            const dropdown = document.getElementById('languageDropdown');
            const chevron = document.getElementById('languageChevron');
            
            dropdown.classList.toggle('active');
            chevron.style.transform = dropdown.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('languageDropdown');
            const button = event.target.closest('button[onclick="toggleLanguageDropdown()"]');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
                document.getElementById('languageChevron').style.transform = 'rotate(0deg)';
            }
        });

        // Close dropdown when pressing Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const dropdown = document.getElementById('languageDropdown');
                dropdown.classList.remove('active');
                document.getElementById('languageChevron').style.transform = 'rotate(0deg)';
            }
        });

      
    </script>
</body>
</html>
    <!-- Main Dashboard -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 animate-fade-in">
        <!-- Enhanced Shortcuts Grid -->
        <div class="shortcuts-grid">
            <!-- Quick Actions -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.shortcuts_dashboard_subtitle') }}</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    <!-- Add Payment -->
                    @can('create payments')
                    <a href="{{ route('admin.payments.create') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800/30 dark:hover:to-blue-700/30 transition-all duration-200 border border-blue-200 dark:border-blue-700">
                        <div
                            class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                           <i class="fas fa-money-bill-wave text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.add_payment') }}</span>
                    </a>
                    @endcan
                    <!-- Add Expense -->
                    @can('create expenses')
                    <a href="{{ route('admin.expenses.create') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 hover:from-red-100 hover:to-red-200 dark:hover:from-red-800/30 dark:hover:to-red-700/30 transition-all duration-200 border border-red-200 dark:border-red-700">
                        <div
                            class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                           <i class="fas fa-receipt text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.add_expense') }}</span>
                    </a>
                    @endcan                    
                    <!-- units.available -->
                    @can('view available units')
                    <a href="{{ route('units.available') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 hover:from-green-100 hover:to-green-200 dark:hover:from-green-800/30 dark:hover:to-green-700/30 transition-all duration-200 border border-green-200 dark:border-green-700">
                        <div
                            class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                           <i class="fas fa-home text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.available_rooms') }}</span>
                    </a>
                    @endcan
                    <!-- Book Room -->
                    @can('create bookings')
                    <a href="{{ route('admin.bookings.create') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 hover:from-indigo-100 hover:to-indigo-200 dark:hover:from-indigo-800/30 dark:hover:to-indigo-700/30 transition-all duration-200 border border-indigo-200 dark:border-indigo-700">
                        <div
                            class="w-12 h-12 bg-indigo-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                             <i class="fas fa-bed text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.book_room') }}</span>
                    </a>
                    @endcan
                    <!-- My Bookings -->
                    @can('view bookings')                    
                    <a href="{{ route('admin.bookings.index', ['my' => true]) }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 hover:from-purple-100 hover:to-purple-200 dark:hover:from-purple-800/30 dark:hover:to-purple-700/30 transition-all duration-200 border border-purple-200 dark:border-purple-700">
                        <div
                            class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-calendar-check text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.my_bookings') }}</span>
                    </a>
                    @endcan
                    <!-- Cleaning Dashboard -->
                    @can('view cleaning dashboard')
                    <a href="{{ route('admin.cleaning.dashboard') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 hover:from-cyan-100 hover:to-cyan-200 dark:hover:from-cyan-800/30 dark:hover:to-cyan-700/30 transition-all duration-200 border border-cyan-200 dark:border-cyan-700">
                        <div
                            class="w-12 h-12 bg-cyan-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-broom text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.cleaning_dashboard') }}</span>
                    </a>
                    @endcan
                     <!-- maintenance -->
                    @role('Maintenance Supervisor')
                    <a href="{{ route('admin.maintenance_requests.index') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 hover:from-amber-100 hover:to-amber-200 dark:hover:from-amber-800/30 dark:hover:to-amber-700/30 transition-all duration-200 border border-amber-200 dark:border-amber-700">
                        <div
                            class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-wrench text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.maintenance') }}</span>
                    </a>
                    @endrole
					<!-- my_order_maintenance -->
                    @role('technician')
                    <a href="{{ route('admin.technician.maintenance') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 hover:from-amber-100 hover:to-amber-200 dark:hover:from-amber-800/30 dark:hover:to-amber-700/30 transition-all duration-200 border border-amber-200 dark:border-amber-700">
                        <div
                            class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-wrench text-white text-xl sm:text-2xl" > </i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.my_order_maintenance') }}</span>
                    </a>
                    @endrole
                     <!-- Add Maintenance Request -->
                     @can('create maintenance requests')
                    <a href="{{ route('admin.maintenance_requests.create') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 hover:from-orange-100 hover:to-orange-200 dark:hover:from-orange-800/30 dark:hover:to-orange-700/30 transition-all duration-200 border border-orange-200 dark:border-orange-700">
                        <div
                            class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-tools text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.add_maintenance_request') }}</span>
                    </a>
                    @endcan
                    <!-- Available Rooms (Text Version) -->
                    @can('view available units')
                    <a href="{{ url('/admin/units-available-text') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 hover:from-emerald-100 hover:to-emerald-200 dark:hover:from-emerald-800/30 dark:hover:to-emerald-700/30 transition-all duration-200 border border-emerald-200 dark:border-emerald-700">
                        <div
                            class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-file-alt text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.available_text_rooms') }}</span>
                    </a>
                    @endcan
                    <!-- utilities -->
                    @can('view utilities')
                    <a href="{{ route('admin.building-utilities.index') }}"
                        class="group flex flex-col items-center p-4 rounded-xl bg-gradient-to-b from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 hover:from-yellow-100 hover:to-yellow-200 dark:hover:from-yellow-800/30 dark:hover:to-yellow-700/30 transition-all duration-200 border border-yellow-200 dark:border-yellow-700">
                        <div
                            class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                           <i class="fas fa-bolt text-white text-xl sm:text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 text-center">{{ __('messages.utilities') }}</span>
                    </a>
                    @endcan
                </div>
            </div>     
            </div>
        </div>
    </div>
	
	 <!-- Demo Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4"></h2>
            <p class="text-gray-600 dark:text-gray-300"></p>
        </div>
    </main>
</main>

<script>
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
    }

    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true' || 
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
</script>

</body>

</html>