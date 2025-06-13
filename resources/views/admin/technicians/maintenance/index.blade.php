@extends('layouts.app')

@section('title', __('messages.my_maintenance_requests'))

@section('content')
    <div class="container mx-auto px-4 py-6 dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white mb-2">
                {{ __('messages.my_maintenance_requests') }}
            </h1>

            {{-- Total Count --}}
            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-4">
                <p class="text-blue-800 dark:text-blue-100 font-semibold">
                    {{ __('messages.total_requests') }}: <span class="text-2xl">{{ $requests->total() }}</span>
                </p>
            </div>

            {{-- Filter Section --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 mb-6 border border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ request()->url() }}" id="filterForm"
                    class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    <div class="flex-1">
                        <label for="building_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
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
                    <div class="flex flex-wrap gap-2 items-end">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'new']) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition-colors text-sm">
                            جديد
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'delayed']) }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md transition-colors text-sm">
                            المؤجل
                        </a>
                        <a href="{{ request()->url() }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors text-sm">
                            {{ __('messages.clear_filter') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Requests List --}}
        @forelse ($requests as $request)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 md:p-6 mb-4 border border-gray-200 dark:border-gray-700 transition-all hover:shadow-lg">
                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-white flex-1">
                        #{{ $request->id }} — {{ __('messages.fault_type') }}: {{ $request->subSpecialty->name ?? '-' }}
                    </h2>
                    <span
                        class="inline-block px-3 py-1 text-xs md:text-sm rounded-full font-medium   
                        @if ($request->status === 'new') bg-yellow-300 dark:bg-yellow-600 text-blue-800 dark:text-white
                        @elseif($request->status === 'in_progress') bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-white
                        @elseif($request->status === 'completed') bg-green-200 dark:bg-green-700 text-green-800 dark:text-white
                        @elseif($request->status === 'delayed') bg-orange-400 dark:bg-orange-600 text-red-800 dark:text-white
                        @elseif($request->status === 'rejected') bg-red-100 dark:bg-red-700 text-red-800 dark:text-white
                        @else bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-white @endif">
                        {{ __('messages.status_labels.' . $request->status) }}
                    </span>
                </div>

                {{-- Details Section --}}
                <div class="mt-4 space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                        <span class="font-medium">{{ __('messages.unit') }}:</span>
                        <span class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 text-white text-sm font-bold shadow">
                                {{ $request->unit->unit_number ?? '-' }}
                            </span>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($request->unit->building->location ?? '') }}"
                                target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $request->unit->building->name ?? '-' }}
                            </a>
                        </span>
                    </div>

                    @if ($request->unit->status === 'occupied' && $request->unit->latestContract && $request->unit->latestContract->tenant)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="font-medium">{{ __('messages.tenant_phone') }}:</span>
                            <div class="flex items-center gap-2">
                                <a href="tel:{{ $request->unit->latestContract->tenant->phone }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $request->unit->latestContract->tenant->phone }}
                                </a>
                                @if ($request->unit->latestContract->tenant->is_whatsapp)
                                    <a href="https://wa.me/{{ ltrim($request->unit->latestContract->tenant->phone, '+') }}" 
                                       target="_blank" 
                                       class="text-green-600 dark:text-green-400">
                                        <i class="fab fa-whatsapp text-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="font-medium">{{ __('messages.created_by') }}:</span>
                            <span>{{ $request->creator->name ?? '-' }}</span>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="font-medium">{{ __('messages.created_at') }}:</span>
                            <span>{{ $request->created_at->format('Y-m-d H:i') }}</span>
                        </div>

                        @if ($request->in_progress_at)
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                <span class="font-medium">{{ __('messages.in_progress_at') }}:</span>
                                <span>{{ $request->in_progress_at->format('Y-m-d H:i') }}</span>
                            </div>
                        @endif

                        @if ($request->completed_at)
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                <span class="font-medium">{{ __('messages.completed_at') }}:</span>
                                <span>{{ $request->completed_at->format('Y-m-d H:i') }}</span>
                            </div>
                        @endif

                        @if ($request->rejected_at)
                            <div class="md:col-span-2">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                    <span class="font-medium">{{ __('messages.rejected_at') }}:</span>
                                    <span>{{ $request->rejected_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="text-red-600 dark:text-red-400 mt-1">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.problem_images') }}
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ asset('storage/' . $request->image) }}" data-fancybox="gallery-{{ $request->id }}" class="block">
                                <img src="{{ asset('storage/' . $request->image) }}" alt="Problem Image" 
                                     class="h-24 w-24 object-cover rounded-md border border-gray-200 dark:border-gray-600">
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3">

                        {{-- Start Work Button --}}
                        @if (in_array($request->status, ['new', 'delayed']))
                            <form action="{{ route('maintenance.start', $request->id) }}" method="POST"
                                class="flex-shrink-0">
                                @csrf
                                <button type="submit"
                                    class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition-colors font-medium text-sm">
                                    <i class="fas fa-play-circle mr-1"></i> {{ __('messages.start_work') }}
                                </button>
                            </form>
                        @endif

                        {{-- Complete Work Form --}}
                        @if ($request->status === 'in_progress' && !$request->completed_image)
                            <div class="flex-1 min-w-full sm:min-w-0">
                                <form action="{{ route('maintenance.complete', $request->id) }}" method="POST"
                                    enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            <i class="fas fa-camera mr-1"></i> {{ __('messages.upload_completion_image') }}
                                        </label>
                                        <input type="file" name="completed_image" accept="image/*" capture="environment"
                                            required
                                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-700">
                                    </div>
                                    <button type="submit"
                                        class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors font-medium text-sm">
                                        <i class="fas fa-check-circle mr-1"></i> {{ __('messages.mark_as_completed') }}
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Action Buttons Row --}}
                        @if (in_array($request->status, ['new', 'in_progress', 'delayed']))
                            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                                {{-- Reject Button --}}
                                <form id="reject-form-{{ $request->id }}"
                                    action="{{ route('maintenance.reject', $request->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="note" id="note-input-{{ $request->id }}">
                                    <button type="button" onclick="promptReject({{ $request->id }})"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors font-medium text-sm">
                                        <i class="fas fa-times-circle mr-1"></i> {{ __('messages.reject_request') }}
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
                                            class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md transition-colors font-medium text-sm">
                                            <i class="fas fa-clock mr-1"></i> {{ __('messages.delay_request') }}
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
                <div class="text-gray-400 dark:text-gray-500 text-6xl mb-4">📋</div>
                <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('messages.no_requests') }}</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($requests->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
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
    </script>

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

        [dir="rtl"] .mr-1 {
            margin-right: 0 !important;
            margin-left: 0.25rem !important;
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            .bg-white, .dark\\:bg-gray-800 {
                border-radius: 0;
                margin-left: -0.75rem;
                margin-right: -0.75rem;
                width: calc(100% + 1.5rem);
            }
        }

        /* Dark mode transitions */
        .dark * {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Button improvements */
        button, .btn {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
            min-height: 42px;
        }

        /* Focus styles */
        button:focus, input:focus, select:focus, textarea:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        /* Status badges */
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        /* Image gallery */
        [data-fancybox] img {
            transition: transform 0.2s ease;
        }
        
        [data-fancybox]:hover img {
            transform: scale(1.03);
        }

        /* Form inputs */
        input[type="file"]::-webkit-file-upload-button {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.25rem 0.75rem;
            margin-right: 0.5rem;
            cursor: pointer;
        }

        .dark input[type="file"]::-webkit-file-upload-button {
            background-color: #374151;
            border-color: #4b5563;
            color: #f3f4f6;
        }
    </style>
@endsection