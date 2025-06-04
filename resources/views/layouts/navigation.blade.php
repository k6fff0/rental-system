@php
    $navLinks = [
        [
            'route' => 'admin.dashboard',
            'label' => __('messages.Dashboard'),
            'icon' => 'heroicon-o-home',
        ],
        [
            'label' => __('messages.properties_management'),
            'icon' => 'heroicon-o-building-office',
            'dropdown' => [
                [
                    'route' => 'admin.buildings.index',
                    'label' => __('messages.buildings'),
                    'icon' => 'heroicon-o-building-office',
                ],
                [
                    'route' => 'admin.units.index',
                    'label' => __('messages.units'),
                    'icon' => 'heroicon-o-home-modern',
                ],
                [
                    'route' => 'admin.building-utilities.index',
                    'label' => __('messages.utilities'),
                    'icon' => 'heroicon-o-bolt',
                ],
                [
                    'route' => '#',
                    'label' => __('messages.cars'),
                    'icon' => 'heroicon-o-truck',
                ],
            ],
        ],
        [
            'label' => __('messages.tenants_management'),
            'icon' => 'heroicon-o-users',
            'dropdown' => [
                [
                    'route' => 'admin.tenants.index',
                    'label' => __('messages.tenants'),
                    'icon' => 'heroicon-o-users',
                ],
                [
                    'route' => 'admin.contracts.index',
                    'label' => __('messages.contracts'),
                    'icon' => 'heroicon-o-document-text',
                ],
                [
                    'route' => 'admin.bookings.index',
                    'label' => __('messages.room_bookings'),
                    'icon' => 'heroicon-o-calendar-days',
                ],
            ],
        ],
        [
            'label' => __('messages.financial_management'),
            'icon' => 'heroicon-o-currency-dollar',
            'dropdown' => [
                [
                    'route' => 'admin.payments.index',
                    'label' => __('messages.payments'),
                    'icon' => 'heroicon-o-credit-card',
                ],
                [
                    'route' => 'admin.expenses.index',
                    'label' => __('messages.expenses'),
                    'icon' => 'heroicon-o-receipt-percent',
                ],

            ],
        ],
        [
            'label' => __('messages.maintenance_management'),
            'icon' => 'heroicon-o-wrench-screwdriver',
            'dropdown' => [
                [
                    'route' => 'admin.maintenance_requests.index',
                    'label' => __('messages.maintenance'),
                    'icon' => 'heroicon-o-wrench-screwdriver',
                ],
                [
                    'route' => 'admin.technicians.index',
                    'label' => __('messages.technicians_department'),
                    'icon' => 'heroicon-o-user-group',
                ],
				        [
            'route' => 'admin.maintenance_requests.archive',
            'label' => __('messages.maintenance_archive'),
            'icon' => 'heroicon-o-archive-box',
        ],
            ],
        ],
        [
            'label' => __('messages.system_management'),
            'icon' => 'heroicon-o-cog',
            'dropdown' => [
                [
                    'route' => 'admin.users.index',
                    'label' => __('messages.users'),
                    'icon' => 'heroicon-o-user-circle',
                ],
                [
                    'route' => 'admin.building-supervisors.index',
                    'label' => __('messages.building_supervisors'),
                    'icon' => 'heroicon-o-user',
                ],
                [
                    'route' => 'admin.role_manager.index',
                    'label' => __('messages.permissions'),
                    'icon' => 'heroicon-o-shield-check',
                ],
                [
                    'route' => '#',
                    'label' => __('messages.ratings'),
                    'icon' => 'heroicon-o-star',
                ],

            ],
        ],
    ];
@endphp

<nav x-data="{ open: false, notificationsOpen: false, activeDropdown: null }"
    class="relative w-full z-[9999] bg-white dark:bg-gray-900 border-b border-gray-200/50 dark:border-gray-700/50">

    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-18">

            {{-- الشعار --}}
            <div class="flex items-center gap-4 rtl:flex-row-reverse min-w-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group hover:scale-105 transition-transform duration-300">
                    @if (settings()->app_logo)
                        <div class="relative">
                            <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Logo" class="h-10 w-10 rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-300">
                        </div>
                    @else
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-lg">{{ substr(config('app.name'), 0, 1) }}</span>
                        </div>
                    @endif

                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                            {{ config('app.name') }}
                        </h1>
                    </div>
                </a>

                {{-- زر الرجوع --}}
                @if (!request()->routeIs('dashboard'))
                    <button onclick="history.back()"
                        class="group relative p-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300"
                        title="{{ __('messages.back') }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transform group-hover:-translate-x-0.5 transition-all duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                @endif
            </div>

            {{-- روابط التنقل - Desktop --}}
            <div class="hidden lg:flex items-center gap-1 flex-1 justify-center max-w-4xl">
                @foreach ($navLinks as $index => $link)
                    @if (isset($link['dropdown']))
                        {{-- قائمة منسدلة --}}
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative group" style="z-index: 9999">
                            <button
                                class="flex items-center gap-4 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 group hover:bg-gray-50 dark:hover:bg-gray-800/50"
                                :class="open ? 'bg-gray-50 dark:bg-gray-800/50 text-blue-600 dark:text-blue-400' :
                                    'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400'">
                                <x-dynamic-component :component="$link['icon']" class="h-5 w-5 flex-shrink-0" />
                                <span class="hidden 2xl:inline whitespace-nowrap">{{ $link['label'] }}</span>
                                <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- القائمة المنسدلة --}}
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                                class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-64 origin-top"
                                style="z-index: 9999">
                                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-xl overflow-hidden">
                                    <div class="p-2 space-y-1">
                                        @foreach ($link['dropdown'] as $dropdownLink)
                                            @php
                                                $isNamedRoute = $dropdownLink['route'] !== '#';
                                                $url = $isNamedRoute ? route($dropdownLink['route']) : '#';
                                                $isActive = $isNamedRoute && request()->routeIs($dropdownLink['route'] . '*');
                                            @endphp

                                            <a href="{{ $url }}"
                                                class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-300 {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
                                                <x-dynamic-component :component="$dropdownLink['icon']"
                                                    class="h-5 w-5 flex-shrink-0 {{ $isActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 group-hover:text-blue-500' }}" />
                                                <span class="flex-1">{{ $dropdownLink['label'] }}</span>
                                                @if ($isActive)
                                                    <div class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400"></div>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
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
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 relative group {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-blue-600 dark:hover:text-blue-400' }}"
                            title="{{ $link['label'] }}">
                            <x-dynamic-component :component="$link['icon']" class="h-5 w-5 flex-shrink-0" />
                            <span class="hidden sm:inline whitespace-nowrap">{{ $link['label'] }}</span>
                            @if ($isActive)
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- الإشعارات والمستخدم - Desktop --}}
            <div class="hidden sm:flex items-center gap-3 rtl:flex-row-reverse">
                {{-- زر الإشعارات --}}
                <div class="relative" x-data="{ open: false, hasNew: {{ $unreadNotificationsCount > 0 ? 'true' : 'false' } }">
                    <button @click="open = !open"
                        class="relative p-3 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300 group"
                        :class="open ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-600' : ''">
                        <x-heroicon-o-bell
                            class="h-5 w-6 text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300" />

                        @if ($unreadNotificationsCount > 0)
                            <div class="absolute -top-1 -right-1 flex items-center justify-center">
                                <div class="absolute h-3 w-3 bg-red-500 rounded-full animate-ping"></div>
                                <div class="relative h-3 w-3 bg-red-500 rounded-full flex items-center justify-center">
                                    @if ($unreadNotificationsCount > 9)
                                        <span class="text-[8px] text-white font-bold">9+</span>
                                    @else
                                        <span class="text-[8px] text-white font-bold">{{ $unreadNotificationsCount }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </button>

                    {{-- قائمة الإشعارات --}}
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                        class="absolute right-0 mt-3 w-96 origin-top-right z-[9999]">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-xl overflow-hidden">
                            {{-- رأس الإشعارات --}}
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.notifications') }}</h3>
                                @if ($unreadNotificationsCount > 0)
                                    <p class="text-sm text-blue-600 dark:text-blue-400">{{ $unreadNotificationsCount }} {{ __('messages.new_notifications') }}</p>
                                @endif
                            </div>

                            {{-- قائمة الإشعارات --}}
                            <div class="max-h-80 overflow-y-auto">
                                @forelse($recentNotifications as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}"
                                        class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0 p-2 rounded-xl {{ $notification->read_at ? 'bg-gray-100 dark:bg-gray-700' : 'bg-blue-100 dark:bg-blue-900/30' }}">
                                                <x-dynamic-component :component="$notification->data['icon'] ?? 'heroicon-o-information-circle'"
                                                    class="h-5 w-5 {{ $notification->read_at ? 'text-gray-500' : 'text-blue-600 dark:text-blue-400' }}" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-gray-900 dark:text-white text-sm leading-5">
                                                    {{ $notification->data['title'] ?? __('messages.notification') }}
                                                </p>
                                                @if (!empty($notification->data['message']))
                                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">
                                                        {{ $notification->data['message'] }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            @if (!$notification->read_at)
                                                <div class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400 flex-shrink-0 mt-2"></div>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-6 py-8 text-center">
                                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                            <x-heroicon-o-bell-slash class="h-8 w-8 text-gray-400" />
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('messages.no_notifications') }}</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- أسفل الإشعارات --}}
                            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                                <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors duration-300">
                                        {{ __('messages.mark_all_read') }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.notifications.index') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white font-medium transition-colors duration-300">
                                    {{ __('messages.view_all') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- المستخدم --}}
                @include('layouts.partials.user-dropdown')
            </div>

            {{-- أزرار الموبايل --}}
            <div class="flex items-center gap-2 sm:hidden">
                {{-- زر الإشعارات للموبايل --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="relative p-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300">
                        <x-heroicon-o-bell class="h-5 w-5 text-gray-600 dark:text-gray-300" />
                        @if ($unreadNotificationsCount > 0)
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full flex items-center justify-center">
                                <span class="text-[8px] text-white font-bold">{{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}</span>
                            </div>
                        @endif
                    </button>

                    {{-- قائمة الإشعارات للموبايل --}}
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-80 max-w-[calc(100vw-2rem)] origin-top-right z-[9999]">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20">
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('messages.notifications') }}</h3>
                            </div>

                            <div class="max-h-64 overflow-y-auto">
                                @forelse($recentNotifications->take(3) as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" @click="open = false"
                                        class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                        <div class="flex items-start gap-3">
                                            <x-dynamic-component :component="$notification->data['icon'] ?? 'heroicon-o-information-circle'"
                                                class="h-4 w-4 text-blue-500 mt-1 flex-shrink-0" />
                                            <div class="min-w-0 flex-1">
                                                <p class="font-medium text-gray-900 dark:text-white text-sm truncate">
                                                    {{ $notification->data['title'] ?? __('messages.notification') }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('messages.no_notifications') }}
                                    </div>
                                @endforelse
                            </div>

                            <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700 text-center">
                                <a href="{{ route('admin.notifications.index') }}" @click="open = false"
                                    class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                    {{ __('messages.view_all_notifications') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- زر القائمة الرئيسية --}}
                <button @click="open = !open"
                    class="p-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- قائمة الموبايل --}}
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden lg:hidden bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50">
        <div class="px-4 py-4 space-y-2 max-h-[calc(100vh-4rem)] overflow-y-auto">
            @foreach ($navLinks as $link)
                @if (isset($link['dropdown']))
                    <div x-data="{ expanded: false }" class="space-y-1">
                        <button @click="expanded = !expanded"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-left font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <x-dynamic-component :component="$link['icon']" class="h-5 w-5 flex-shrink-0" />
                                <span>{{ $link['label'] }}</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="expanded" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-96"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 max-h-96" x-transition:leave-end="opacity-0 max-h-0"
                            class="overflow-hidden">
                            <div class="pl-6 space-y-1">
                                @foreach ($link['dropdown'] as $dropdownLink)
                                    @php
                                        $isNamedRoute = $dropdownLink['route'] !== '#';
                                        $url = $isNamedRoute ? route($dropdownLink['route']) : '#';
                                        $isActive = $isNamedRoute && request()->routeIs($dropdownLink['route'] . '*');
                                    @endphp

                                    <a href="{{ $url }}" @click="open = false"
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-300 {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
                                        <x-dynamic-component :component="$dropdownLink['icon']" class="h-4 w-4 flex-shrink-0" />
                                        <span>{{ $dropdownLink['label'] }}</span>
                                        @if ($isActive)
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-600 dark:bg-blue-400 ml-auto"></div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    @php
                        $isNamedRoute = $link['route'] !== '#';
                        $url = $isNamedRoute ? route($link['route']) : '#';
                        $isActive = $isNamedRoute && request()->routeIs($link['route'] . '*');
                    @endphp

                    <a href="{{ $url }}" @click="open = false"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-300 {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-blue-600 dark:hover:text-blue-400' }}">
                        <x-dynamic-component :component="$link['icon']" class="h-5 w-5 flex-shrink-0" />
                        <span>{{ $link['label'] }}</span>
                        @if ($isActive)
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-600 dark:bg-blue-400 ml-auto"></div>
                        @endif
                    </a>
                @endif
            @endforeach

            {{-- خط فاصل --}}
            <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

            {{-- معلومات المستخدم في الموبايل --}}
            @include('layouts.partials.user-dropdown-mobile')
        </div>
    </div>
</nav>

{{-- مساحة للمحتوى تحت شريط التنقل --}}
<div class="h-16 lg:h-18"></div>