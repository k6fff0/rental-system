@extends('layouts.app')
@section('title', __('messages.edit_assigned_buildings'))

@push('styles')
    <style>
        .building-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .building-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .building-card.locked {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }

        .building-card.assigned {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #3b82f6;
        }

        .checkbox-custom {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            background: white;
            position: relative;
            cursor: pointer;
            transition: all 0.2s;
        }

        .checkbox-custom:checked {
            background: #3b82f6;
            border-color: #3b82f6;
        }

        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-custom:disabled {
            background: #f3f4f6;
            border-color: #d1d5db;
            cursor: not-allowed;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
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

        .progress-bar {
            height: 4px;
            background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 2px;
            transition: width 0.3s ease;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50 py-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-building text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.edit_assigned_buildings') }}</h1>
                            <p class="text-sm text-gray-600 mt-1">{{ __('messages.manage_supervisor_buildings') }}</p>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <a href="{{ route('admin.building-supervisors.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors space-x-2 rtl:space-x-reverse">
                        <i class="fas fa-arrow-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs"></i>
                        <span>{{ __('messages.back') }}</span>
                    </a>
                </div>

                {{-- Progress Indicator --}}
                <div class="w-full bg-gray-200 rounded-full h-1 mb-4">
                    <div class="progress-bar w-1/3" id="progressBar"></div>
                </div>
            </div>

            <form action="{{ route('admin.building-supervisors.update', $user->id) }}" method="POST" id="buildingForm">
                @csrf
                @method('PUT')

                {{-- Supervisor Info Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 fade-in">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-tie text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('messages.supervisor_name') }}
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $user->name }}" disabled
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-medium focus:outline-none">
                                <div
                                    class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buildings Selection --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-in">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ __('messages.select_buildings') }}</h2>
                            <p class="text-sm text-gray-600 mt-1">{{ __('messages.assign_buildings_description') }}</p>
                        </div>

                        {{-- Selection Counter --}}
                        <div class="bg-blue-50 px-4 py-2 rounded-lg">
                            <span class="text-sm font-medium text-blue-700">
                                <span id="selectedCount">0</span> {{ __('messages.selected') }}
                            </span>
                        </div>
                    </div>

                    {{-- Buildings Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @foreach ($buildings as $building)
                            @php
                                $isAssigned = in_array($building->id, $assigned);
                                $isLocked = in_array($building->id, $assignedToOthers) && !$isAssigned;
                            @endphp

                            <div
                                class="building-card {{ $isLocked ? 'locked' : ($isAssigned ? 'assigned' : '') }} 
                                    border-2 {{ $isAssigned ? 'border-blue-300' : 'border-gray-200' }} 
                                    rounded-xl p-4 {{ $isLocked ? 'opacity-60' : '' }}">
                                <label class="flex items-center space-x-3 rtl:space-x-reverse cursor-pointer">
                                    <input type="checkbox" name="buildings[]" value="{{ $building->id }}"
                                        {{ $isAssigned ? 'checked' : '' }} {{ $isLocked ? 'disabled' : '' }}
                                        class="checkbox-custom building-checkbox" onchange="updateCounter()">

                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h3
                                                class="font-semibold text-gray-900 {{ $isLocked ? 'line-through text-gray-500' : '' }}">
                                                {{ $building->name }}
                                            </h3>

                                            @if ($isLocked)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">
                                                    <i class="fas fa-lock mr-1 rtl:mr-0 rtl:ml-1"></i>
                                                    {{ __('messages.assigned_to_other') }}
                                                </span>
                                            @elseif($isAssigned)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                                    <i class="fas fa-check mr-1 rtl:mr-0 rtl:ml-1"></i>
                                                    {{ __('messages.assigned') }}
                                                </span>
                                            @endif
                                        </div>

                                        @if ($building->address)
                                            <p class="text-sm text-gray-600 mt-1">
                                                <i class="fas fa-map-marker-alt mr-1 rtl:mr-0 rtl:ml-1"></i>
                                                {{ $building->address }}
                                            </p>
                                        @endif

                                        @if (isset($building->units_count))
                                            <p class="text-xs text-gray-500 mt-2">
                                                {{ $building->units_count }} {{ __('messages.units') }}
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- Legend --}}
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ __('messages.legend') }}</h3>
                        <div class="flex flex-wrap gap-4 text-xs">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <div class="w-4 h-4 bg-blue-500 border-2 border-blue-300 rounded"></div>
                                <span class="text-gray-600">{{ __('messages.currently_assigned') }}</span>
                            </div>
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <div class="w-4 h-4 bg-gray-400 border-2 border-gray-300 rounded opacity-60"></div>
                                <span class="text-gray-600">{{ __('messages.assigned_to_others') }}</span>
                            </div>
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <div class="w-4 h-4 bg-white border-2 border-gray-300 rounded"></div>
                                <span class="text-gray-600">{{ __('messages.available') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="flex space-x-3 rtl:space-x-reverse">
                            <button type="button" onclick="selectAll()"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-check-double mr-2 rtl:mr-0 rtl:ml-2"></i>
                                {{ __('messages.select_all') }}
                            </button>

                            <button type="button" onclick="deselectAll()"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-times mr-2 rtl:mr-0 rtl:ml-2"></i>
                                {{ __('messages.deselect_all') }}
                            </button>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2 rtl:mr-0 rtl:ml-2"></i>
                            {{ __('messages.save_changes') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateCounter() {
                const checkboxes = document.querySelectorAll('.building-checkbox:checked:not(:disabled)');
                const count = checkboxes.length;
                document.getElementById('selectedCount').textContent = count;

                // Update progress bar
                const total = document.querySelectorAll('.building-checkbox:not(:disabled)').length;
                const percentage = total > 0 ? (count / total) * 100 : 0;
                document.getElementById('progressBar').style.width = percentage + '%';
            }

            function selectAll() {
                const checkboxes = document.querySelectorAll('.building-checkbox:not(:disabled)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                    checkbox.closest('.building-card').classList.add('assigned');
                });
                updateCounter();
            }

            function deselectAll() {
                const checkboxes = document.querySelectorAll('.building-checkbox:not(:disabled)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    checkbox.closest('.building-card').classList.remove('assigned');
                });
                updateCounter();
            }

            // Initialize counter on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateCounter();

                // Add change event listeners
                document.querySelectorAll('.building-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const card = this.closest('.building-card');
                        if (this.checked) {
                            card.classList.add('assigned');
                        } else {
                            card.classList.remove('assigned');
                        }
                    });
                });
            });

            // Form validation
            document.getElementById('buildingForm').addEventListener('submit', function(e) {
                const selectedBuildings = document.querySelectorAll('.building-checkbox:checked:not(:disabled)').length;

                if (selectedBuildings === 0) {
                    e.preventDefault();
                    alert('{{ __('messages.please_select_at_least_one_building') }}');
                    return false;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>{{ __('messages.saving') }}...';
                submitBtn.disabled = true;

                // Re-enable button after 5 seconds (fallback)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            });
        </script>
    @endpush
@endsection
