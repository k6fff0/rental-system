@php
    $navLinks = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'heroicon-o-home'],
        ['route' => 'admin.buildings.index', 'label' => __('messages.buildings'), 'icon' => 'heroicon-o-building-office'],
        ['route' => 'admin.units.index', 'label' => __('messages.units'), 'icon' => 'heroicon-o-home-modern'],
        ['route' => 'admin.tenants.index', 'label' => __('messages.tenants'), 'icon' => 'heroicon-o-users'],
        ['route' => 'admin.contracts.index', 'label' => __('messages.contracts'), 'icon' => 'heroicon-o-document-text'],
        ['route' => 'admin.maintenance_requests.index', 'label' => __('messages.maintenance'), 'icon' => 'heroicon-o-wrench-screwdriver'],
        ['route' => 'admin.expenses.index', 'label' => __('messages.expenses'), 'icon' => 'heroicon-o-receipt-percent'],
        ['route' => 'admin.users.index', 'label' => __('messages.users'), 'icon' => 'heroicon-o-user-circle'],
        ['route' => 'admin.role_manager.index', 'label' => __('messages.permissions'), 'icon' => 'heroicon-o-shield-check'],
    ];
@endphp

<nav x-data="{ open: false, notificationsOpen: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- الجزء الأيسر (الشعار وزر الرجوع) -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <!-- الشعار -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <x-application-logo class="block h-9 w-auto fill-current text-blue-600" />
                        <span class="ml-2 text-xl font-bold text-gray-800 hidden md:inline">{{ config('app.name') }}</span>
                    </a>
                </div>

                <!-- زر الرجوع -->
                @if(!request()->routeIs('dashboard'))
                <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-blue-600 text-sm font-medium transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 rtl:ml-1 rtl:mr-0 group-hover:translate-x-[-2px] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('messages.back') }}
                </a>
                @endif
            </div>

            <!-- القائمة الرئيسية -->
            <div class="hidden sm:flex items-center space-x-1 rtl:space-x-reverse">
                @foreach ($navLinks as $link)
                    @php
                        $isNamedRoute = $link['route'] !== '#';
                        $url = $isNamedRoute ? route($link['route']) : '#';
                        $isActive = $isNamedRoute && request()->routeIs($link['route'] . '*');
                    @endphp

                    <a href="{{ $url }}" class="px-3 py-2 rounded-md text-sm font-medium transition flex items-center group" title="{{ $link['label'] }}" @if($isActive) aria-current="page" @endif>
                        <span class="mr-2 text-gray-500 group-hover:text-blue-600 {{ $isActive ? 'text-blue-600' : '' }}">
                            <x-dynamic-component :component="$link['icon']" class="h-4 w-4" />
                        </span>
                        <span class="hidden md:inline {{ $isActive ? 'text-blue-800 font-semibold' : 'text-gray-600 hover:text-blue-600' }}">
                            {{ $link['label'] }}
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- إشعارات والمستخدم -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3 rtl:space-x-reverse">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-1 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none relative">
                        <x-heroicon-o-bell class="h-5 w-5" />
                        @if($unreadNotificationsCount > 0)
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        @endif
                    </button>
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            @forelse($recentNotifications as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center">
                                    <x-dynamic-component :component="$notification->data['icon'] ?? 'heroicon-o-information-circle'" class="h-4 w-4 text-blue-500 mr-2" />
                                    <div>
                                        <p class="font-medium">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="px-4 py-3 text-sm text-gray-500 text-center">
                                {{ __('messages.no_notifications') }}
                            </div>
                            @endforelse
                            <div class="border-t border-gray-100">
                                <a href="{{ route('admin.notifications.index') }}" class="block px-4 py-2 text-sm text-center text-blue-600 hover:bg-blue-50">
                                    {{ __('messages.view_all_notifications') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @include('layouts.partials.user-dropdown')
            </div>

            <!-- القائمة الجانبية للهاتف -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- قائمة الجوال -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($navLinks as $link)
                @php
                    $isNamedRoute = $link['route'] !== '#';
                    $url = $isNamedRoute ? route($link['route']) : '#';
                    $isActive = $isNamedRoute && request()->routeIs($link['route'] . '*');
                @endphp

                <x-responsive-nav-link :href="$url" :active="$isActive" class="flex items-center">
                    <x-dynamic-component :component="$link['icon']" class="h-4 w-4 mr-2" />
                    {{ $link['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        @include('layouts.partials.user-dropdown-mobile')
    </div>
</nav>