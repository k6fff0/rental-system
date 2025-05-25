{{-- 🧭 روابط التنقل --}}
@php
    $navLinks = [
        [
            'route' => 'admin.dashboard', 
            'label' => 'Dashboard', 
            'icon' => 'heroicon-o-home'
        ],
        [
            'label' => __('messages.properties_management'),
            'icon' => 'heroicon-o-building-office',
            'dropdown' => [
                [
                    'route' => 'admin.buildings.index', 
                    'label' => __('messages.buildings'), 
                    'icon' => 'heroicon-o-building-office'
                ],
                [
                    'route' => 'admin.units.index', 
                    'label' => __('messages.units'), 
                    'icon' => 'heroicon-o-home-modern'
                ],

            ]
        ],
        [
            'label' => __('messages.tenants_management'),
            'icon' => 'heroicon-o-users',
            'dropdown' => [
                [
                    'route' => 'admin.tenants.index', 
                    'label' => __('messages.tenants'), 
                    'icon' => 'heroicon-o-users'
                ],
                [
                    'route' => 'admin.contracts.index', 
                    'label' => __('messages.contracts'), 
                    'icon' => 'heroicon-o-document-text'
                ],

            ]
        ],
        [
            'label' => __('messages.financial_management'),
            'icon' => 'heroicon-o-currency-dollar',
            'dropdown' => [
                [
                    'route' => '#', 
                    'label' => __('messages.payments'), 
                    'icon' => 'heroicon-o-credit-card'
                ],
                [
                    'route' => 'admin.expenses.index', 
                    'label' => __('messages.expenses'), 
                    'icon' => 'heroicon-o-receipt-percent'
                ],
				 [
                    'route' => '#', 
                    'label' => __('messages.cars'), 
                    'icon' => 'heroicon-o-truck'
                ],
            ]
        ],
        [
            'label' => __('messages.maintenance_management'),
            'icon' => 'heroicon-o-wrench-screwdriver',
            'dropdown' => [
                [
                    'route' => 'admin.maintenance_requests.index', 
                    'label' => __('messages.maintenance'), 
                    'icon' => 'heroicon-o-wrench-screwdriver'
                ],
                [
                    'route' => 'admin.technicians.index', 
                    'label' => __('messages.technicians_department'), 
                    'icon' => 'heroicon-o-user-group'
                ],
            ]
        ],
        [
            'label' => __('messages.system_management'),
            'icon' => 'heroicon-o-cog',
            'dropdown' => [
                [
                    'route' => 'admin.users.index', 
                    'label' => __('messages.users'), 
                    'icon' => 'heroicon-o-user-circle'
                ],
                [
                    'route' => 'admin.role_manager.index', 
                    'label' => __('messages.permissions'), 
                    'icon' => 'heroicon-o-shield-check'
                ],
			    [
                    'route' => '#', 
                    'label' => __('messages.ratings'), 
                    'icon' => 'heroicon-o-star'
                ],
			   
            ]
        ],
    ];
@endphp

<nav x-data="{ open: false, notificationsOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- 🎯 الشعار وزر الرجوع --}}
            <div class="flex items-center gap-4 rtl:flex-row-reverse">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    @if (settings()->app_logo)
    <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Logo" class="h-9 w-auto rounded-md">
@else
    <img src="{{ asset('images/default-logo.png') }}" alt="Default Logo" class="h-9 w-auto rounded-md">
@endif

                    <span class="ml-2 text-xl font-bold text-gray-800 dark:text-white hidden md:inline">
                        {{ config('app.name') }}
                    </span>
                </a>

              @if(!request()->routeIs('dashboard'))
    <a href="{{ url()->previous() }}" 
       class="flex items-center justify-center p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-900/50 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 shadow-sm hover:shadow-md"
       title="{{ __('messages.back') }}">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-5 w-5 transform transition-transform duration-300 hover:-translate-x-1" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
@endif
            </div>

            {{-- 🌐 روابط التنقل الرئيسية --}}
            <div class="hidden sm:flex items-center gap-2 rtl:flex-row-reverse">
                @foreach ($navLinks as $link)
                    @if(isset($link['dropdown']))
                        {{-- قائمة منسدلة --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="px-3 py-2 rounded-md text-sm font-medium transition flex items-center group"
                                    :class="{{ isset($link['route']) ? "request()->routeIs('{$link['route']}*') ? 'text-blue-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600'" : "'text-gray-600 dark:text-gray-300 hover:text-blue-600'" }}">
                                <span class="mr-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 {{ isset($link['route']) && request()->routeIs($link['route'].'*') ? 'text-blue-600' : '' }}">
                                    <x-dynamic-component :component="$link['icon']" class="h-4 w-4" />
                                </span>
                                <span class="hidden md:inline">
                                    {{ $link['label'] }}
                                </span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    @foreach($link['dropdown'] as $dropdownLink)
                                        @php
                                            $isNamedRoute = $dropdownLink['route'] !== '#';
                                            $url = $isNamedRoute ? route($dropdownLink['route']) : '#';
                                            $isActive = $isNamedRoute && request()->routeIs($dropdownLink['route'] . '*');
                                        @endphp

                                        <a href="{{ $url }}"
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center"
                                           @if($isActive) aria-current="page" @endif>
                                            <x-dynamic-component :component="$dropdownLink['icon']" class="h-4 w-4 mr-2" />
                                            {{ $dropdownLink['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- رابط عادي --}}
                        @php
                            $isNamedRoute = $link['route'] !== '#';
                            $url = $isNamedRoute ? route($link['route']) : '#';
                            $isActive = $isNamedRoute && request()->routeIs($link['route'] . '*');
                        @endphp

                        <a href="{{ $url }}"
                           class="px-3 py-2 rounded-md text-sm font-medium transition flex items-center group"
                           title="{{ $link['label'] }}" @if($isActive) aria-current="page" @endif>
                            <span class="mr-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 {{ $isActive ? 'text-blue-600' : '' }}">
                                <x-dynamic-component :component="$link['icon']" class="h-4 w-4" />
                            </span>
                            <span class="hidden md:inline {{ $isActive ? 'text-blue-800 dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600' }}">
                                {{ $link['label'] }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- 🔔 إشعارات + المستخدم --}}
            <div class="hidden sm:flex items-center gap-3 rtl:flex-row-reverse">

                {{-- 🔔 الجرس --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="p-1 rounded-full text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none relative">
                        <x-heroicon-o-bell class="h-5 w-5" />
                        @if($unreadNotificationsCount > 0)
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-[999]">
                        <div class="py-1 max-h-80 overflow-y-auto">
                            @forelse($recentNotifications as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                    <div class="flex items-center">
                                        <x-dynamic-component :component="$notification->data['icon'] ?? 'heroicon-o-information-circle'"
                                                             class="h-4 w-4 text-blue-500 mr-2" />
                                        <div>
                                            <p class="font-medium">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                    {{ __('messages.no_notifications') }}
                                </div>
                            @endforelse
                        </div>

                        {{-- ✅ زر تمييز الكل كمقروء + رابط عرض الكل --}}
                        <div class="border-t border-gray-100 dark:border-gray-700 flex justify-between items-center px-4 py-2">
                            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                @csrf
                                <button type="submit"
                                        class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    ✔️ {{ __('messages.mark_all_read') }}
                                </button>
                            </form>

                            <a href="{{ route('admin.notifications.index') }}"
                               class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('messages.view_all_notifications') }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 🧑‍🤝‍🧑 المستخدم --}}
                @include('layouts.partials.user-dropdown')
            </div>

            {{-- 📱 زر الجوال --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 📱 قائمة الجوال --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white dark:bg-gray-800 shadow-lg z-[999]">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($navLinks as $link)
                @if(isset($link['dropdown']))
                    <div class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300">
                        {{ $link['label'] }}
                    </div>
                    @foreach($link['dropdown'] as $dropdownLink)
                        @php
                            $isNamedRoute = $dropdownLink['route'] !== '#';
                            $url = $isNamedRoute ? route($dropdownLink['route']) : '#';
                            $isActive = $isNamedRoute && request()->routeIs($dropdownLink['route'] . '*');
                        @endphp

                        <x-responsive-nav-link :href="$url" :active="$isActive" class="flex items-center pl-8">
                            <x-dynamic-component :component="$dropdownLink['icon']" class="h-4 w-4 mr-2" />
                            {{ $dropdownLink['label'] }}
                        </x-responsive-nav-link>
                    @endforeach
                @else
                    @php
                        $isNamedRoute = $link['route'] !== '#';
                        $url = $isNamedRoute ? route($link['route']) : '#';
                        $isActive = $isNamedRoute && request()->routeIs($link['route'] . '*');
                    @endphp

                    <x-responsive-nav-link :href="$url" :active="$isActive" class="flex items-center">
                        <x-dynamic-component :component="$link['icon']" class="h-4 w-4 mr-2" />
                        {{ $link['label'] }}
                    </x-responsive-nav-link>
                @endif
            @endforeach
        </div>

        @include('layouts.partials.user-dropdown-mobile')
    </div>
</nav>