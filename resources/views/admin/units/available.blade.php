@extends('layouts.app')

@section('title', __('الوحدات المتاحة'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Header Section -->
        <div class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-5"></div>
            <div class="relative max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('الوحدات المتاحة') }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        {{ __('اكتشف مجموعة متنوعة من الوحدات السكنية المتاحة للإيجار بأفضل الأسعار') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 transition-all duration-300">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="w-full md:w-auto flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="smart-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="{{ __('ابحث برقم الغرفة أو اسم المبنى...') }}" onkeyup="filterUnits()">
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('إجمالي الوحدات:') }}
                        </span>
                        <span
                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $units->total() ?? count($units) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Units Grid -->
            <div id="units-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($units as $unit)
                    <div class="unit-card group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden"
                        data-unit-number="{{ $unit->unit_number }}" data-building-name="{{ $unit->building->name }}"
                        data-floor="{{ $unit->floor }}" data-type="{{ __('messages.' . $unit->unit_type) }}"
                        data-price="{{ $unit->rent_price }}">

                        <!-- Image Gallery with Fancybox -->
                        <div class="relative h-48 overflow-hidden rounded-t-2xl">
                            @if ($unit->images->isNotEmpty())
                                <div class="grid grid-cols-2 gap-1 h-full">
                                    @foreach ($unit->images->take(4) as $image)
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                            data-fancybox="gallery-{{ $unit->id }}"
                                            data-caption="{{ __('وحدة') }} {{ $unit->unit_number }} - {{ __('صورة') }} {{ $loop->iteration }}"
                                            class="@if ($loop->first) row-span-2 col-span-2 @else h-full @endif">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                class="w-full h-full object-cover hover:opacity-90 transition-opacity"
                                                alt="{{ __('صورة الوحدة') }}">
                                        </a>
                                    @endforeach
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                            @else
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ __('متاحة') }}
                                </span>
                            </div>

                            <!-- Building Name -->
                            <div class="absolute bottom-4 left-4 text-white">
                                <a href="{{ $unit->building->location_url }}" target="_blank"
                                    class="flex items-center space-x-2 rtl:space-x-reverse hover:underline">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm">{{ $unit->building->name }}</span>
                                </a>
                            </div>
                        </div>

                        <!-- Unit Details -->
                        <div class="p-6">
                            <!-- Unit Number & Rating -->
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('وحدة') }} {{ $unit->unit_number }}
                                </h3>
                                <div class="flex items-center text-yellow-500">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                            <!-- Unit Info -->
                            <div class="space-y-3 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        {{ __('الدور:') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $unit->floor }}</span>
                                </div>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('النوع:') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ __('messages.' . $unit->unit_type) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ number_format($unit->rent_price, 0) }}
                                        <span class="text-sm text-gray-500 dark:text-gray-400 font-normal">
                                            {{ __('درهم/شهر') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-3 rtl:space-x-reverse">
                                <a href="{{ route('admin.units.show', $unit->id) }}"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 text-center text-sm shadow-lg hover:shadow-xl transform hover:scale-105">
                                    {{ __('عرض التفاصيل') }}
                                </a>

                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div class="text-center py-16">
                            <div
                                class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ __('لا توجد وحدات متاحة حالياً') }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                                {{ __('نعتذر، لا توجد وحدات متاحة للإيجار في الوقت الحالي. يرجى المحاولة لاحقاً.') }}
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('العودة للوحة التحكم') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if (isset($units) && method_exists($units, 'links'))
                <div class="mt-12 flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-2">
                        {{ $units->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>


    <style>
        /* RTL Support */
        [dir="rtl"] .rtl\:space-x-reverse> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 1;
        }

        /* Custom Pagination */
        .pagination {
            @apply flex items-center space-x-1 rtl:space-x-reverse;
        }

        .pagination .page-link {
            @apply px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200;
        }

        .pagination .page-item.active .page-link {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }

        .pagination .page-item.disabled .page-link {
            @apply text-gray-400 cursor-not-allowed hover:bg-transparent;
        }

        /* Hover Animations */
        .group:hover .transform {
            transform: translateY(-4px);
        }

        /* Dark Mode Support */
        .dark .dark\:from-gray-900 {
            --tw-gradient-from: #111827;
            --tw-gradient-to: rgba(17, 24, 39, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }

        .dark .dark\:to-gray-800 {
            --tw-gradient-to: #1f2937;
        }

        /* Mobile Responsiveness */
        @media (max-width: 640px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .px-4 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .py-12 {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }

        @media (max-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Fancybox Custom Styles */
        .fancybox__toolbar {
            @apply bg-gray-800 bg-opacity-70;
        }

        .fancybox__nav {
            @apply bg-gray-800 bg-opacity-50;
        }

        .fancybox__thumbs {
            @apply bg-gray-100 dark:bg-gray-800;
        }

        .fancybox__button {
            @apply text-white hover:bg-gray-700;
        }

        /* Grid Layout */
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* Search Highlight */
        .highlight {
            background-color: #fef08a;
            color: #854d0e;
            padding: 0.1em 0.2em;
            border-radius: 0.2em;
        }

        /* Network Status Indicator */
        .network-status {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            z-index: 1000;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .network-online {
            background-color: #10b981;
            color: white;
        }

        .network-offline {
            background-color: #ef4444;
            color: white;
        }

        .network-status svg {
            margin-right: 8px;
        }
    </style>

    <script>
        // Initialize Fancybox
        document.addEventListener('DOMContentLoaded', function() {
            Fancybox.bind("[data-fancybox]", {
                Thumbs: {
                    autoStart: false,
                },
                Toolbar: {
                    display: {
                        left: [],
                        middle: [],
                        right: ["close"],
                    },
                },
            });

            // Add fade-in animation to cards on scroll
            const cards = document.querySelectorAll('.unit-card');

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            cards.forEach(card => {
                observer.observe(card);
            });

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
        });

        // Smart search filter function
        function filterUnits() {
            const searchTerm = document.getElementById('smart-search').value.toLowerCase();
            const unitCards = document.querySelectorAll('.unit-card');

            unitCards.forEach(card => {
                const unitNumber = card.getAttribute('data-unit-number').toLowerCase();
                const buildingName = card.getAttribute('data-building-name').toLowerCase();
                const floor = card.getAttribute('data-floor').toLowerCase();
                const type = card.getAttribute('data-type').toLowerCase();
                const price = card.getAttribute('data-price').toLowerCase();

                if (unitNumber.includes(searchTerm) ||
                    buildingName.includes(searchTerm) ||
                    floor.includes(searchTerm) ||
                    type.includes(searchTerm) ||
                    price.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Initialize network status
        function initNetworkStatus() {
            const networkStatus = document.createElement('div');
            networkStatus.className = 'network-status';
            networkStatus.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
        </svg>
        <span>${navigator.onLine ? 'متصل بالإنترنت' : 'غير متصل'}</span>
    `;

            networkStatus.classList.add(navigator.onLine ? 'network-online' : 'network-offline');
            document.body.appendChild(networkStatus);

            window.addEventListener('online', () => {
                networkStatus.classList.remove('network-offline');
                networkStatus.classList.add('network-online');
                networkStatus.querySelector('span').textContent = 'متصل بالإنترنت';
            });

            window.addEventListener('offline', () => {
                networkStatus.classList.remove('network-online');
                networkStatus.classList.add('network-offline');
                networkStatus.querySelector('span').textContent = 'غير متصل';
            });
        }

        // Initialize network status on load
        initNetworkStatus();
    </script>
    <script>
        // تفعيل Fancybox للمعرض
        $(document).ready(function() {
            $('[data-fancybox]').fancybox({
                loop: true,
                animationEffect: "zoom-in-out",
                transitionEffect: "slide",
                thumbs: {
                    autoStart: true,
                    hideOnClose: true
                },
                toolbar: {
                    display: ["zoom", "slideShow", "fullScreen", "thumbs", "close"]
                },
                lang: 'ar',
                i18n: {
                    'ar': {
                        'CLOSE': 'إغلاق',
                        'NEXT': 'التالي',
                        'PREV': 'السابق'
                    }
                }
            });
        });
    </script>
@endsection
