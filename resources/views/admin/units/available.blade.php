@extends('layouts.app')

@section('title', __('الوحدات المتاحة'))

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
      <!-- Header Section -->
<header class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-lg">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-5"></div>

    <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Flex row for image + text -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-12 text-center sm:text-start"
             dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            
            <!-- ✅ Logo Circle -->
            <div class="w-32 h-32 object-contain rounded-2xl overflow-hidden shadow-md border-4 border-white dark:border-gray-700 shrink-0">
                <img src="{{ asset('storage/' . settings()->app_logo) }}"
                     alt="Logo"
                     class="w-full h-full object-cover">
            </div>

            <!-- ✅ Title & Subtitle -->
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    {{ __('messages.available_units_title') }}
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 max-w-2xl">
                    {{ __('messages.available_units_subtitle') }}
                </p>
            </div>
        </div>
    </div>
</header>



        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <section class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 md:p-6 transition-all duration-300">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="w-full md:w-auto flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="smart-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="{{ __('messages.search_placeholder_available_units') }}" onkeyup="filterUnits()">
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.total_units') }}
                        </span>
                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $units->total() ?? count($units) }}
                        </span>
                    </div>
                </div>
            </section>

            <!-- Units Grid -->
            <section id="units-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($units as $unit)
                    <article class="unit-card group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden"
                        data-unit-number="{{ $unit->unit_number }}" 
                        data-building-name="{{ $unit->building->name }}"
                        data-floor="{{ $unit->floor }}" 
                        data-type="{{ __('messages.' . $unit->unit_type) }}"
                        data-price="{{ $unit->rent_price }}">

                        <!-- Image Gallery with Fancybox -->
                      <div class="relative aspect-[4/3] bg-gray-100 dark:bg-gray-800 rounded-t-2xl overflow-hidden object-cover">

                            @if ($unit->images->isNotEmpty())
                                <div class="relative h-48 overflow-hidden   h-full rounded-t-2xl bg-gray-100 dark:bg-gray-800">
                                    @foreach ($unit->images->skip(1) as $image)
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                            data-fancybox="gallery-{{ $unit->id }}"
                                            data-caption="{{ __('وحدة') }} {{ $unit->unit_number }} - {{ __('صورة') }} {{ $loop->iteration }}"
                                            class="@if ($loop->first) row-span-2 col-span-2 @else h-full @endif">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
											 loading="lazy"
										     alt="{{ __('messages.unit_image') }}"
                                             class="w-full h-full object-cover "                                                
                                        </a>
                                    @endforeach
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-10 pointer-events-none"></div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-semibold">
                                   {{ __('messages.available') }}
                                </span>
                            </div>

                           
                        </div>

                        <!-- Unit Details -->
                        <div class="p-4">
                            <!-- Unit Number & Rating -->
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ __('messages.unit') }} {{ $unit->unit_number }}
                                </h3>
								
                                <div class="flex items-center text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
<!-- Building Name Under Unit -->
<a href="{{ $unit->building->location_url }}" target="_blank"
   class="inline-flex items-center text-xs sm:text-sm text-indigo-600 dark:text-indigo-400 hover:underline mt-1 space-x-1 rtl:space-x-reverse">
    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
    </svg>
    <span>{{ $unit->building->name }}</span>
</a>

                            <!-- Unit Info -->
                            <div class="space-y-2 mb-3">
                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        {{ __('messages.floor') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $unit->floor }}</span>
                                </div>

                                <div class="flex items-center justify-between text-xs sm:text-sm">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('messages.type') }}
                                    </span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ __('messages.' . $unit->unit_type) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ number_format($unit->rent_price, 0) }}
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">
                                            {{ __('messages.aed') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2 rtl:space-x-reverse">
                                <a href="{{ route('admin.bookings.create', ['unit_id' => $unit->id]) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold shadow transition flex-1 justify-center">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a1 1 0 011 1v6h6a1 1 0 110 2h-6v6a1 1 0 11-2 0v-6H3a1 1 0 110-2h6V3a1 1 0 011-1z" />
                                    </svg>
                                    {{ __('messages.book_now') }}
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ __('messages.no_units_available') }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto text-sm">
                                {{ __('messages.no_units_message') }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 text-sm">
                                    <svg class="w-4 h-4 mr-2 rtl:ml-2 rtl:mr-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('messages.back_to_dashboard') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </section>

            <!-- Pagination -->
            @if (isset($units) && method_exists($units, 'links'))
                <div class="mt-8 flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-2">
                        {{ $units->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </main>
    </div>
@endsection

@section('styles')
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
            @apply px-2.5 py-1.5 text-xs sm:text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-200;
        }

        .pagination .page-item.active .page-link {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }

        .pagination .page-item.disabled .page-link {
            @apply text-gray-400 cursor-not-allowed hover:bg-transparent;
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
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

        .fancybox__button {
            @apply text-white hover:bg-gray-700;
        }

        /* Network Status Indicator */
        .network-status {
            position: fixed;
            bottom: 16px;
            right: 16px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            z-index: 1000;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            margin-right: 6px;
        }

        /* Responsive Adjustments */
        @media (max-width: 640px) {
            .unit-card {
                max-width: 100%;
            }
            
            .pagination .page-link {
                @apply px-2 py-1 text-xs;
            }
        }

        @media (min-width: 640px) and (max-width: 1024px) {
            #units-container {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Print Styles */
        @media print {
            .unit-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- Fancybox CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.min.js"></script>

    <script>
        // Initialize Fancybox with Arabic language
        document.addEventListener('DOMContentLoaded', function() {
            Fancybox.bind("[data-fancybox]", {
                l10n: {
                    CLOSE: "إغلاق",
                    NEXT: "التالي",
                    PREV: "السابق",
                    MODAL: "يمكنك إغلاق هذه النافذة بالضغط على ESC",
                    ERROR: "حدث خطأ، يرجى المحاولة لاحقاً",
                    IMAGE_ERROR: "الصورة غير موجودة",
                    ELEMENT_NOT_FOUND: "العنصر غير موجود",
                    AJAX_NOT_FOUND: "حدث خطأ في التحميل: غير موجود",
                    AJAX_FORBIDDEN: "حدث خطأ في التحميل: محظور",
                    IFRAME_ERROR: "حدث خطأ في تحميل الصفحة",
                    TOGGLE_ZOOM: "تكبير/تصغير",
                    TOGGLE_THUMBS: "إظهار/إخفاء الصور المصغرة",
                    TOGGLE_SLIDESHOW: "تشغيل/إيقاف العرض التلقائي",
                    TOGGLE_FULLSCREEN: "ملء الشاشة",
                    DOWNLOAD: "تحميل"
                },
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
                Image: {
                    zoom: true,
                    wheel: false,
                }
            });

            // Add intersection observer for lazy loading and animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -20px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                        
                        // Lazy load images
                        const lazyImages = entry.target.querySelectorAll('img[loading="lazy"]');
                        lazyImages.forEach(img => {
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                            }
                        });
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.unit-card').forEach(card => {
                observer.observe(card);
            });

            // Initialize network status
            initNetworkStatus();
        });

        // Smart search filter function
        function filterUnits() {
            const searchTerm = document.getElementById('smart-search').value.toLowerCase().trim();
            const unitCards = document.querySelectorAll('.unit-card');

            unitCards.forEach(card => {
                const cardData = card.textContent.toLowerCase() + ' ' + 
                                card.getAttribute('data-unit-number').toLowerCase() + ' ' +
                                card.getAttribute('data-building-name').toLowerCase() + ' ' +
                                card.getAttribute('data-floor').toLowerCase() + ' ' +
                                card.getAttribute('data-type').toLowerCase() + ' ' +
                                card.getAttribute('data-price').toLowerCase();

                if (searchTerm === '' || cardData.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Network status indicator
        function initNetworkStatus() {
            const networkStatus = document.createElement('div');
            networkStatus.className = 'network-status';
            networkStatus.innerHTML = `
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        // Service Worker Registration for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(registration => {
                    console.log('ServiceWorker registration successful');
                }).catch(err => {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
@endsection