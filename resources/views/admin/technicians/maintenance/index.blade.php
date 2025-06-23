@extends('layouts.app')

@section('title', __('messages.my_maintenance_requests'))

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <div class="container mx-auto px-3 py-4 max-w-7xl">
            {{-- Header Section --}}
            <div class="mb-4">
                <h1 class="text-xl font-bold text-gray-800 dark:text-white mb-3">
                    {{ __('messages.my_maintenance_requests') }}
                </h1>

                {{-- Total Count Card --}}
                <div
                    class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-xl p-3 mb-4 shadow-lg">
                    <p class="text-white font-semibold text-sm">
                        {{ __('messages.total_requests') }}:
                        <span class="text-xl font-bold">{{ $requests->total() }}</span>
                    </p>
                </div>

                {{-- Compact Filter Section --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-3 mb-4 shadow-sm border border-gray-100 dark:border-gray-700">
                    <form method="GET" action="{{ request()->url() }}" id="filterForm">
                        {{-- Building Filter --}}
                        <div class="mb-3">
                            <select name="building_id" id="building_filter"
                                onchange="document.getElementById('filterForm').submit()"
                                class="w-full text-sm border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">{{ __('messages.all_buildings') }}</option>
                                @foreach ($buildings ?? [] as $building)
                                    <option value="{{ $building->id }}"
                                        {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Quick Filter Buttons --}}
                        <div class="flex gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'new']) }}"
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium py-2 px-3 rounded-lg text-center transition-colors">
                                {{ __('messages.new') }}
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'delayed']) }}"
                                class="flex-1 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium py-2 px-3 rounded-lg text-center transition-colors">
                                {{ __('messages.delayed') }}
                            </a>
                            <a href="{{ request()->url() }}"
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white text-xs font-medium py-2 px-3 rounded-lg text-center transition-colors">
                                {{ __('messages.clear') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Organized Requests Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
                @forelse ($requests as $request)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">



                        {{-- Header Row --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-lg font-bold text-blue-600 dark:text-blue-400">#{{ $request->id }}</span>
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-500 text-white text-xs font-bold">
                                    {{ $request->unit->unit_number ?? '—' }}
                                </span>
                            </div>
                            <span
                                class="text-xs px-2 py-1 rounded-full font-medium whitespace-nowrap
        @if ($request->status === 'new') bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300
        @elseif($request->status === 'in_progress') bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300
        @elseif($request->status === 'completed') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300
        @elseif($request->status === 'delayed') bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-300
        @elseif($request->status === 'rejected') bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300
        @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 @endif">
                                {{ __('messages.status_labels.' . $request->status) }}
                            </span>
                        </div>

                        @php
                            $building = $request->unit->building ?? $request->building;
                            $buildingName = $building->name ?? '—';
                            $buildingLocation = $building->location ?? null;
                        @endphp

                        <div class="mb-3">

                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($request->unit->building->location ?? '') }}"
                                target="_blank"
                                class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:underline block truncate">
                                📍 {{ $buildingName }}
                            </a>
                            <span
                                class="inline-block bg-blue-200 dark:bg-gray-700 text-xs font-medium text-gray-700 dark:text-gray-300 px-2 py-1 rounded mt-1">
                                {{ $request->subSpecialty->name ?? 'غير محدد' }}
                            </span>
                        </div>





                        {{-- Contact Info --}}
                        @php
                            $unit = $request->unit;
                            $contract = $unit?->latestContract;
                            $tenant = $contract?->tenant;
                            $showTenantPhone = $unit?->status === 'occupied' && $contract && $tenant;
                        @endphp

                        @if ($showTenantPhone || $request->extra_phone)
                            <div class="mb-3 bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                                <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                    <i class="fas fa-phone text-blue-500"></i> {{ __('messages.contact') }}:
                                </div>

                                {{-- رقم المستأجر المرتبط بالعقد --}}
                                @if ($showTenantPhone)
                                    <div class="flex items-center gap-2 bg-white dark:bg-gray-600 rounded px-2 py-1 mb-1">
                                        <a href="tel:{{ $tenant->phone }}"
                                            class="text-blue-600 dark:text-blue-400 text-xs font-medium hover:underline flex-1 truncate">
                                            {{ $tenant->phone }}
                                        </a>
                                        @if ($tenant->is_whatsapp)
                                            <a href="https://wa.me/{{ ltrim($tenant->phone, '+') }}" target="_blank"
                                                class="text-green-600 dark:text-green-400">
                                                <i class="fab fa-whatsapp text-sm"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                {{-- رقم إضافي (زوج / أخ / أي جهة تواصل) --}}
                                @if ($request->extra_phone)
                                    <div class="flex items-center gap-2 bg-white dark:bg-gray-600 rounded px-2 py-1">
                                        <a href="tel:{{ $request->extra_phone }}"
                                            class="text-blue-600 dark:text-blue-400 text-xs font-medium hover:underline flex-1 truncate">
                                            {{ $request->extra_phone }}
                                        </a>
                                        @if ($request->is_whatsapp)
                                            <a href="https://wa.me/{{ ltrim($request->extra_phone, '+') }}" target="_blank"
                                                class="text-green-600 dark:text-green-400">
                                                <i class="fab fa-whatsapp text-sm"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif


                        {{-- Creator Info --}}
                        <div class="mb-3">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.created_by') }}:</span>
                                <span
                                    class="font-medium text-gray-800 dark:text-gray-200 truncate">{{ $request->creator->name ?? __('messages.not_specified') }}</span>
                            </div>
                        </div>
                        {{-- Emergency Alert --}}
                        @if ($request->is_emergency)
                            <div
                                class="bg-red-700 text-white px-3 py-1 rounded-lg mb-4 text-center text-xl font-bold animate-pulse">
                                🚨 {{ __('messages.emergency_request') }} 🚨
                            </div>
                        @endif
                        {{-- Timeline --}}
                        <div class="mb-3">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">
                                <i class="fas fa-clock text-purple-500"></i> {{ __('messages.timeline') }}:
                            </div>
                            <div class="space-y-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ __('messages.created_at') }}:</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $request->created_at->format('d/m/Y - H:i') }}</span>
                                </div>

                                @if ($request->in_progress_at)
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.started_at') }}:</span>
                                        <span class="font-medium text-yellow-600 dark:text-yellow-400">
                                            {{ $request->in_progress_at->format('d/m/Y - H:i') }}</span>
                                    </div>
                                @endif

                                @if ($request->delayed_at)
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.delayed_at') }}:</span>
                                        <span
                                            class="font-medium text-orange-600 dark:text-orange-400">{{ $request->delayed_at->format('d/m/Y - H:i') }}</span>
                                    </div>
                                @endif

                                @if ($request->completed_at)
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.completed_at') }}:</span>
                                        <span
                                            class="font-medium text-green-600 dark:text-green-400">{{ $request->completed_at->format('d/m/Y - H:i') }}</span>
                                    </div>
                                @endif

                                @if ($request->rejected_at)
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        <span
                                            class="text-gray-600 dark:text-gray-400">{{ __('messages.rejected_at') }}:</span>
                                        <span
                                            class="font-medium text-red-600 dark:text-red-400">{{ $request->rejected_at->format('d/m/Y - H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Image & Description --}}
                        <div class="mb-3">
                            @if ($request->image)
                                <div class="mb-2">
                                    <div class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                        <i class="fas fa-image text-green-500"></i> {{ __('messages.problem_image') }}:
                                    </div>
                                    <a href="{{ asset('storage/' . $request->image) }}"
                                        data-fancybox="gallery-{{ $request->id }}">
                                        <img src="{{ asset('storage/' . $request->image) }}" alt="Problem Image"
                                            class="h-16 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-600 hover:scale-105 transition-transform">
                                    </a>
                                </div>
                            @endif

                            <button onclick="showDescription('{{ addslashes($request->description) }}')"
                                class="text-blue-600 dark:text-blue-400 hover:underline text-xs font-medium flex items-center gap-1 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-lg w-full justify-center">
                                <i class="fas fa-file-text"></i> {{ __('messages.view_problem_description') }}
                            </button>
                        </div>

                        {{-- Delay Note --}}
                        @if ($request->status === 'delayed' && $request->note)
                            <div
                                class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg p-2 mb-3">
                                <div class="text-xs font-medium text-orange-600 dark:text-orange-400 mb-1">
                                    <i class="fas fa-clock"></i> {{ __('messages.delay_note') }}:
                                </div>
                                <p class="text-orange-600 dark:text-orange-400 text-xs">
                                    {{ $request->note }}
                                </p>
                            </div>
                        @endif

                        {{-- Rejection Note --}}
                        @if ($request->rejected_at && $request->rejection_note)
                            <div class="mb-3">
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2">
                                    <div class="text-xs font-medium text-red-600 dark:text-red-400 mb-1">
                                        <i class="fas fa-exclamation-triangle"></i> {{ __('messages.rejection_note') }}:
                                    </div>
                                    <p class="text-red-600 dark:text-red-400 text-xs">
                                        {{ $request->rejection_note }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($request->audio_note)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">🎧 التسجيل الصوتي:</p>
                                <audio controls class="w-full max-w-sm rounded shadow">
                                    <source src="{{ asset('storage/' . $request->audio_note) }}" type="audio/webm">
                                    المتصفح لا يدعم تشغيل ملفات webm.
                                </audio>
                            </div>
                        @endif
						
                        {{-- Action Buttons --}}
                        <div class="space-y-2">
                            {{-- Start Work Button --}}
                            @if (in_array($request->status, ['new', 'delayed']))
                                <form action="{{ route('maintenance.start', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="mt-4 w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 rounded-lg transition-colors font-medium text-xs">
                                        <i class="fas fa-play mr-1"></i> {{ __('messages.start_work') }}
                                    </button>
                                </form>
                            @endif

                            {{-- Complete Work Form --}}
                            @if ($request->status === 'in_progress' && !$request->completed_image)
                                <form action="{{ route('maintenance.complete', $request->id) }}" method="POST"
                                    enctype="multipart/form-data" class="space-y-2">
                                    @csrf
                                    <input type="file" name="completed_image" accept="image/*" capture="environment"
                                        required
                                        class="w-full text-xs border border-gray-200 dark:border-gray-600 rounded-lg px-2 py-1 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <button type="submit"
                                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded-lg transition-colors font-medium text-xs">
                                        <i class="fas fa-check mr-1"></i> {{ __('messages.complete_work') }}
                                    </button>
                                </form>
                            @endif

                            {{-- Action Buttons Row --}}
                            @if (in_array($request->status, ['new', 'in_progress', 'delayed']))
                                <div class="flex gap-2">
                                    {{-- Reject Button --}}
                                    <form id="reject-form-{{ $request->id }}"
                                        action="{{ route('maintenance.reject', $request->id) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <input type="hidden" name="note" id="note-input-{{ $request->id }}">
                                        <button type="button" onclick="promptReject({{ $request->id }})"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg transition-colors font-medium text-xs">
                                            <i class="fas fa-times mr-1"></i> {{ __('messages.reject') }}
                                        </button>
                                    </form>

                                    {{-- Postpone Button --}}
                                    @if (in_array($request->status, ['new', 'in_progress']))
                                        <form id="delay-form-{{ $request->id }}"
                                            action="{{ route('maintenance.delay', $request->id) }}" method="POST"
                                            class="flex-1">
                                            @csrf
                                            <input type="hidden" name="note"
                                                id="delay-note-input-{{ $request->id }}">
                                            <input type="hidden" name="status" value="delayed">
                                            <button type="button" onclick="promptDelay({{ $request->id }})"
                                                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 px-3 rounded-lg transition-colors font-medium text-xs">
                                                <i class="fas fa-clock mr-1"></i> {{ __('messages.postpone') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-400 dark:text-gray-500 text-4xl mb-4">📋</div>
                        <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_requests') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($requests->hasPages())
                <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    {{ $requests->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Description Modal --}}
    <div id="description-modal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-sm w-full max-h-96 overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800 dark:text-white text-sm">وصف المشكلة</h3>
                <button onclick="closeDescription()" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-4 overflow-y-auto max-h-80">
                <div id="description-text" class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                    <!-- يتم تعبئته تلقائياً -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function promptReject(requestId) {
            const note = prompt("{{ __('messages.enter_rejection_note') }}");
            if (note && note.trim()) {
                document.getElementById(`note-input-${requestId}`).value = note.trim();
                document.getElementById(`reject-form-${requestId}`).submit();
            }
        }

        function promptDelay(requestId) {
            const note = prompt("{{ __('messages.enter_delay_note') }}");
            if (note) {
                document.getElementById(`delay-note-input-${requestId}`).value = note;
                document.getElementById(`delay-form-${requestId}`).submit();
            }
        }

        function showDescription(text) {
            document.getElementById('description-text').innerText = text || 'لا يوجد وصف متاح';
            document.getElementById('description-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDescription() {
            document.getElementById('description-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Initialize Fancybox
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind("[data-fancybox]", {
                    l10n: {
                        CLOSE: "{{ __('messages.close') }}",
                        NEXT: "{{ __('messages.next') }}",
                        PREV: "{{ __('messages.prev') }}",
                        MODAL: "{{ __('messages.modal') }}",
                        ERROR: "{{ __('messages.error_loading_image') }}",
                        IMAGE_ERROR: "{{ __('messages.image_not_found') }}",
                        ELEMENT_NOT_FOUND: "{{ __('messages.element_not_found') }}",
                        AJAX_NOT_FOUND: "{{ __('messages.content_not_found') }}",
                        AJAX_FORBIDDEN: "{{ __('messages.access_forbidden') }}",
                        IFRAME_ERROR: "{{ __('messages.iframe_error') }}",
                    }
                });
            }
        });

        // Close modal when clicking outside
        document.getElementById('description-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDescription();
            }
        });
    </script>

    <style>
        /* Enhanced responsive grid system */
        .container {
            max-width: 100%;
        }

        /* Grid breakpoints for better organization */
        @media (min-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1280px) {
            .xl\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1536px) {
            .2xl\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        /* Ensure consistent card heights */
        .grid>div {
            display: flex;
            flex-direction: column;
        }

        /* Enhanced transitions */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        /* Card hover effects */
        .bg-white:hover,
        .dark .dark\\:bg-gray-800:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Focus styles for accessibility */
        button:focus,
        input:focus,
        select:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* File input styling */
        input[type="file"] {
            font-size: 12px;
        }

        input[type="file"]::-webkit-file-upload-button {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.25rem 0.5rem;
            margin-right: 0.5rem;
            font-size: 11px;
            cursor: pointer;
        }

        .dark input[type="file"]::-webkit-file-upload-button {
            background: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }

        /* Image hover effects */
        [data-fancybox] img {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        [data-fancybox]:hover img {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        /* Button press feedback */
        button:active {
            transform: scale(0.98);
        }

        /* RTL Support */
        [dir="rtl"] .mr-1 {
            margin-right: 0 !important;
            margin-left: 0.25rem !important;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* Medium screens - 2 columns */
        @media (min-width: 768px) and (max-width: 1023px) {
            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Large screens optimization */
        @media (min-width: 1440px) {
            .container {
                max-width: 1400px;
                margin: 0 auto;
            }
        }

        /* Very large screens - 5 columns */
        @media (min-width: 1800px) {
            .grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        /* Ensure proper spacing on all screen sizes */
        .grid {
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .grid {
                gap: 1.25rem;
            }
        }

        @media (min-width: 1024px) {
            .grid {
                gap: 1.5rem;
            }
        }

        /* Text truncation utilities */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Enhanced loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Status badge animations */
        .status-badge {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Print styles */
        @media print {
            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
            }

            .bg-white {
                border: 1px solid #ccc;
            }
        }
    </style>
@endsection
