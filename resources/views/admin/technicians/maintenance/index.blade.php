@extends('layouts.app')

@section('title', __('messages.my_maintenance_requests'))

@section('content')
    <div class="container mx-auto px-4 py-6">
        {{-- Header Section --}}
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                {{ __('messages.my_maintenance_requests') }}
            </h1>

            {{-- Total Count --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-blue-800 font-semibold">
                    {{ __('messages.total_requests') }}: <span class="text-2xl">{{ $requests->total() }}</span>
                </p>
            </div>

            {{-- Filter Section --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ request()->url() }}" id="filterForm"
                    class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    <div class="flex-1">
                        <label for="building_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            {{ __('messages.filter_by_building') }}
                        </label>
                        <select name="building_id" id="building_filter" onchange="document.getElementById('filterForm').submit()"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
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
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'new']) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition-colors">
                            جديد
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'delayed']) }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md transition-colors">
                            المؤجل
                        </a>
                        <a href="{{ request()->url() }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors">
                            {{ __('messages.clear_filter') }}
                        </a>
                    </div>
                </form>
            </div>

        </div>

        {{-- Requests List --}}
        @forelse ($requests as $request)
            <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-4 border border-gray-200">
                {{-- Header --}}
                <div class="flex items-center gap-2">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                        #{{ $request->id }} — {{ __('messages.fault_type') }}: {{ $request->subSpecialty->name ?? '-' }}
                    </h2>
                    <span
                        class="inline-block px-3 py-1 text-xs md:text-sm rounded-full font-medium   
                    @if ($request->status === 'new') bg-yellow-300 text-blue-800
                    @elseif($request->status === 'in_progress') bg-yellow-200 text-yellow-800
                    @elseif($request->status === 'completed') bg-green-200 text-green-800
					@elseif($request->status === 'delayed') bg-orange-400 text-red-800
                    @elseif($request->status === 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                        {{ __('messages.status_labels.' . $request->status) }}
                    </span>
                </div>

                {{-- Details Section --}}
                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <span class="font-medium">{{ __('messages.unit') }}:</span>
                        <span class="md:ml-2 flex items-center gap-2 mt-1 md:mt-0">

                            {{-- ✅ رقم الوحدة داخل دائرة ملونة --}}
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white text-sm font-bold shadow">
                                {{ $request->unit->unit_number ?? '-' }}
                            </span>

                            {{-- 🏢 اسم المبنى كرابط على الخريطة --}}
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($request->unit->building->location ?? '') }}"
                                target="_blank" class="text-blue-600 hover:underline">
                                {{ $request->unit->building->name ?? '-' }}
                            </a>
                        </span>
                    </div>

                    @if ($request->unit->status === 'occupied' && $request->unit->latestContract && $request->unit->latestContract->tenant)
                        <div class="flex flex-col md:flex-row md:items-center">
                            <span class="font-medium">📞 {{ __('messages.tenant_phone') }}:</span>
                            <a href="tel:{{ $request->unit->latestContract->tenant->phone }}"
                                class="md:ml-2 text-blue-600 hover:underline">
                                {{ $request->unit->latestContract->tenant->phone }}
                            </a>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <span class="font-medium">{{ __('messages.created_by') }}:</span>
                            {{ $request->creator->name ?? '-' }}
                        </div>

                        <div>
                            <span class="font-medium">{{ __('messages.created_at') }}:</span>
                            {{ $request->created_at->format('Y-m-d H:i') }}
                        </div>

                        @if ($request->in_progress_at)
                            <div>
                                <span class="font-medium">{{ __('messages.in_progress_at') }}:</span>
                                {{ $request->in_progress_at->format('Y-m-d H:i') }}
                            </div>
                        @endif

                        @if ($request->completed_at)
                            <div>
                                <span class="font-medium">{{ __('messages.completed_at') }}:</span>
                                {{ $request->completed_at->format('Y-m-d H:i') }}
                            </div>
                        @endif

                        @if ($request->rejected_at)
                            <div class="md:col-span-2">
                                <div>
                                    <span class="font-medium">{{ __('messages.rejected_at') }}:</span>
                                    {{ $request->rejected_at->format('Y-m-d H:i') }}
                                </div>
                                <div class="text-red-600 mt-1">
                                    <span class="font-medium">{{ __('messages.rejection_note') }}:</span>
                                    {{ $request->rejection_note }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Image Section --}}
                @if ($request->image)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $request->image) }}" data-fancybox="request-{{ $request->id }}"
                            class="inline-flex items-center bg-gray-100 text-blue-600 px-3 py-2 rounded-md text-sm hover:bg-gray-200 transition-colors">
                            📷 {{ __('messages.view_initial_image') }}
                        </a>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="mt-6 border-t pt-4">
                    <div class="flex flex-col md:flex-row md:flex-wrap gap-3">

                        {{-- Start Work Button --}}
                        @if (in_array($request->status, ['new', 'delayed']))
                            <form action="{{ route('maintenance.start', $request->id) }}" method="POST"
                                class="flex-shrink-0">
                                @csrf
                                <button type="submit"
                                    class="w-full md:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition-colors font-medium">
                                    🚀 {{ __('messages.start_work') }}
                                </button>
                            </form>
                        @endif

                        {{-- Complete Work Form --}}
                        @if ($request->status === 'in_progress' && !$request->completed_image)
                            <div class="flex-1 min-w-full md:min-w-0">
                                <form action="{{ route('maintenance.complete', $request->id) }}" method="POST"
                                    enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            {{ __('messages.upload_completion_image') }}
                                        </label>
                                        <input type="file" name="completed_image" accept="image/*" capture="environment"
                                            required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>
                                    <button type="submit"
                                        class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors font-medium">
                                        ✅ {{ __('messages.mark_as_completed') }}
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Action Buttons Row --}}
                        @if (in_array($request->status, ['new', 'in_progress', 'delayed']))
                            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                                {{-- Reject Button --}}
                                <form id="reject-form-{{ $request->id }}"
                                    action="{{ route('maintenance.reject', $request->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="note" id="note-input-{{ $request->id }}">
                                    <button type="button" onclick="promptReject({{ $request->id }})"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors font-medium">
                                        ❌ {{ __('messages.reject_request') }}
                                    </button>
                                </form>

                                {{-- Postpone Button --}}
                                @if (in_array($request->status, ['new', 'in_progress']))
                                    <form id="delay-form-{{ $request->id }}"
                                        action="{{ route('maintenance.delay', $request->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="note" id="delay-note-input-{{ $request->id }}">
                                        <input type="hidden" name="status" value="delayed">
                                        <button type="button" onclick="promptDelay({{ $request->id }})"
                                            class="bg-orange-500 text-white px-4 py-2 rounded">
                                            ⏳ {{ __('messages.delay_request') }}
                                        </button>
                                    </form>
                                @endif

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">📋</div>
                <p class="text-gray-500 text-lg">{{ __('messages.no_requests') }}</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($requests->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    {{ $requests->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
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

        function postponeRequest(requestId) {
            // Placeholder function - currently disabled
            alert("{{ __('messages.postpone_feature_coming_soon') }}");
        }

        // Initialize Fancybox
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind("[data-fancybox]", {
                    // RTL support
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

        // Handle screen orientation changes
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                window.scrollTo(0, 0);
            }, 100);
        });
    </script>

    {{-- Custom CSS for better RTL support and responsiveness --}}
    <style>
        /* RTL Support */
        [dir="rtl"] .container {
            direction: rtl;
        }

        [dir="rtl"] .text-left {
            text-align: right;
        }

        [dir="rtl"] .text-right {
            text-align: left;
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .bg-white {
                margin-left: -0.5rem;
                margin-right: -0.5rem;
                border-radius: 0;
            }

            .bg-white:first-of-type {
                margin-top: -0.5rem;
            }
        }

        /* Button improvements */
        button,
        .btn {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease-in-out;
        }

        /* Loading states */
        form[data-loading] button {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Focus improvements */
        input:focus,
        select:focus,
        button:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
    </style>
@endsection
