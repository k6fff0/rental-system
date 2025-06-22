<!-- Professional Vehicle Management Form -->
<div class="max-w-5xl mx-auto p-4">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Form Header with Gradient -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-8 py-5">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    <span>{{ isset($vehicle) ? __('vehicles.edit_vehicle') : __('vehicles.add_vehicle') }}</span>
                </h2>
                <div class="text-blue-100 text-sm">
                    <span class="font-medium">{{ __('vehicles.required_fields') }}</span> <span
                        class="text-red-300">*</span>
                </div>
            </div>
        </div>

        <form action="{{ isset($vehicle) ? route('vehicles.update', $vehicle->id) : route('vehicles.store') }}"
            method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @if (isset($vehicle))
                @method('PUT')
            @endif
            @php
                $isEdit = isset($vehicle);
                $plate = $isEdit ? explode('-', $vehicle->plate_number) : ['', ''];
                $plateCategory = old('plate_category', $plate[0]);
                $plateNumber = old('plate_number', $plate[1]);
            @endphp
            <!-- Main Form Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Plate Number Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                            {{ __('vehicles.license_plate') }}
                        </h3>

                        <div class="form-group">
                            <label class="form-label required">
                                {{ __('vehicles.plate_number') }}
                            </label>
                            <div class="flex gap-3">
                                <!-- Plate Category -->
                                <div class="w-1/4">
                                    <div class="relative">
                                        <input type="text" name="plate_category" id="plate_category" maxlength="3"
                                            value="{{ $plateCategory }}" pattern="[A-Za-z0-9]{1,3}"
                                            class="form-input uppercase @error('plate_category') error @enderror"
                                            placeholder="A1" title="{{ __('vehicles.plate_category_instructions') }}"
                                            @if ($isEdit) readonly @endif inputmode="latin">
                                        <div class="input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('plate_category')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Plate Number -->
                                <div class="w-3/4">
                                    <div class="relative">
                                        <input type="text" name="plate_number" id="plate_number" maxlength="8"
                                            value="{{ $plateNumber }}"
                                            class="form-input @error('plate_number') error @enderror"
                                            placeholder="123456" pattern="[A-Za-z0-9]{4,8}"
                                            title="{{ __('vehicles.plate_number_instructions') }}"
                                            {{ $isEdit ? 'readonly' : '' }}>
                                        <div class="input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('plate_number')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <p class="form-hint">{{ __('vehicles.plate_format_hint') }}</p>
                        </div>
                    </div>

                    <!-- Vehicle Information Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            {{ __('vehicles.vehicle_information') }}
                        </h3>

                        <!-- Brand -->
                        <div class="form-group">
                            <label for="brand" class="form-label required">
                                {{ __('vehicles.brand') }}
                            </label>
                            <div class="relative">
                                <input type="text" id="brand" name="brand"
                                    value="{{ old('brand', $vehicle->brand ?? '') }}"
                                    class="form-input @error('brand') error @enderror"
                                    placeholder="{{ __('vehicles.enter_brand') }}" required>
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                            </div>
                            @error('brand')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div class="form-group">
                            <label for="model" class="form-label">
                                {{ __('vehicles.model') }}
                            </label>
                            <div class="relative">
                                <input type="text" id="model" name="model"
                                    value="{{ old('model', $vehicle->model ?? '') }}"
                                    class="form-input @error('model') error @enderror"
                                    placeholder="{{ __('vehicles.enter_model') }}">
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                            </div>
                            @error('model')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div class="form-group">
                            <label for="color" class="form-label">
                                {{ __('vehicles.color') }}
                            </label>
                            <div class="flex gap-3 items-center">
                                <div class="relative flex-1">
                                    <input type="text" id="color" name="color"
                                        value="{{ old('color', $vehicle->color ?? '') }}"
                                        class="form-input @error('color') error @enderror"
                                        placeholder="{{ __('vehicles.enter_color') }}">
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                    </div>
                                </div>
                                <input type="color"
                                    class="w-10 h-10 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition"
                                    value="{{ old('color', $vehicle->color ?? '#3b82f6') }}"
                                    onchange="document.getElementById('color').value = this.value">
                            </div>
                            @error('color')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('vehicles.documents') }}
                        </h3>

                        <!-- License Expiry -->
                        <div class="form-group">
                            <label for="license_expiry_date" class="form-label">
                                {{ __('vehicles.license_expiry_date') }}
                            </label>
                            <div class="relative">
                                <input type="date" name="license_expiry_date" id="license_expiry_date"
                                    value="{{ old('license_expiry_date', isset($vehicle) ? $vehicle->license_expiry_date?->format('Y-m-d') : '') }}"
                                    class="form-input @error('license_expiry_date') error @enderror"
                                    min="{{ now()->format('Y-m-d') }}">
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('license_expiry_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Insurance Expiry -->
                        <div class="form-group">
                            <label for="insurance_expiry_date" class="form-label">
                                {{ __('vehicles.insurance_expiry_date') }}
                            </label>
                            <div class="relative">
                                <input type="date" name="insurance_expiry_date" id="insurance_expiry_date"
                                    value="{{ old('insurance_expiry_date', isset($vehicle) ? $vehicle->insurance_expiry_date?->format('Y-m-d') : '') }}"
                                    class="form-input @error('insurance_expiry_date') error @enderror"
                                    min="{{ now()->format('Y-m-d') }}">
                                <div class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            @error('insurance_expiry_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Status Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            {{ __('vehicles.status_configuration') }}
                        </h3>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status" class="form-label required">
                                {{ __('vehicles.status') }}
                            </label>
                            <div class="relative">
                                <select id="status" name="status"
                                    class="form-select @error('status') error @enderror" required>
                                    <option value="available"
                                        {{ old('status', $vehicle->status ?? '') == 'available' ? 'selected' : '' }}>
                                        {{ __('vehicles.status_available') }}
                                    </option>
                                    <option value="in_service"
                                        {{ old('status', $vehicle->status ?? '') == 'in_service' ? 'selected' : '' }}>
                                        {{ __('vehicles.status_in_service') }}
                                    </option>
                                    <option value="broken"
                                        {{ old('status', $vehicle->status ?? '') == 'broken' ? 'selected' : '' }}>
                                        {{ __('vehicles.status_broken') }}
                                    </option>
                                    <option value="maintenance"
                                        {{ old('status', $vehicle->status ?? '') == 'maintenance' ? 'selected' : '' }}>
                                        {{ __('vehicles.status_maintenance') }}
                                    </option>
                                </select>
                                <div class="select-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('status')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Driver Assignment -->
                        <div class="form-group">
                            <label for="user_id" class="form-label">
                                {{ __('vehicles.driver_assignment') }}
                            </label>
                            <div class="relative">
                                <select id="user_id" name="user_id"
                                    class="form-select @error('user_id') error @enderror">
                                    <option value="">{{ __('vehicles.select_driver') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $vehicle->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="select-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('user_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Vehicle Photo Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('vehicles.vehicle_media') }}
                        </h3>

                        <div class="form-group">
                            <label for="photo" class="form-label">
                                {{ __('vehicles.vehicle_photo') }}
                            </label>

                            <!-- File Upload Card -->
                            <div class="file-upload-card" onclick="document.getElementById('photo').click()">
                                <div class="file-upload-content">
                                    <svg class="w-10 h-10 text-blue-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-sm font-medium text-gray-600">
                                        {{ __('vehicles.upload_photo_instructions') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ __('vehicles.supported_formats') }}</p>
                                </div>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*"
                                    onchange="previewImage(this)">
                            </div>

                            <!-- Current Photo Preview -->
                            @if (!empty($vehicle->photo))
                                <div class="current-photo mt-4">
                                    <p class="text-sm font-medium text-gray-600 mb-2">
                                        {{ __('vehicles.current_photo') }}:</p>
                                    <div class="relative inline-block">
                                        <img src="{{ asset('storage/' . $vehicle->photo) }}"
                                            class="photo-preview rounded-lg border border-gray-200 shadow-sm"
                                            alt="{{ __('vehicles.current_photo') }}">
                                        <span class="photo-badge">{{ __('vehicles.current') }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- New Photo Preview -->
                            <div id="new-photo-preview" class="hidden mt-4">
                                <p class="text-sm font-medium text-gray-600 mb-2">{{ __('vehicles.new_photo') }}:</p>
                                <div class="relative inline-block">
                                    <img id="preview-image"
                                        class="photo-preview rounded-lg border border-blue-200 shadow-sm"
                                        alt="{{ __('vehicles.photo_preview') }}">
                                    <span class="photo-badge bg-blue-500">{{ __('vehicles.new') }}</span>
                                </div>
                                <button type="button" onclick="removePreview()"
                                    class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    {{ __('vehicles.remove_photo') }}
                                </button>
                            </div>

                            @error('photo')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            {{ __('vehicles.additional_notes') }}
                        </h3>

                        <div class="form-group">
                            <label for="notes" class="form-label">
                                {{ __('vehicles.notes') }}
                            </label>
                            <div class="relative">
                                <textarea id="notes" name="notes" rows="4" class="form-textarea @error('notes') error @enderror"
                                    placeholder="{{ __('vehicles.enter_notes_placeholder') }}">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
                                <div class="textarea-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2a2 2 0 01-2-2v-8" />
                                    </svg>
                                </div>
                            </div>
                            @error('notes')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-6 mb-4 pt-4 border-t border-gray-200">
                <div class="flex justify-end pr-6"> {{-- زودنا هنا padding right --}}
                    <div class="flex gap-4">
                        {{-- زر الإلغاء --}}
                        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                            </svg>
                            {{ __('vehicles.cancel') }}
                        </a>

                        {{-- زر الحفظ أو التحديث --}}
                        <button type="submit" class="btn btn-primary flex items-center">
                            @if (isset($vehicle))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('vehicles.update_vehicle') }}
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('vehicles.add_vehicle') }}
                            @endif
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('styles')
    <style>
        /* Base Styles */
        .form-section {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .form-section-title {
            display: flex;
            align-items: center;
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .form-section-title svg {
            margin-right: 0.5rem;
            color: #4b5563;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
        }

        .form-label.required::after {
            content: '*';
            color: #ef4444;
            margin-left: 0.25rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.625rem 1rem;
            padding-right: 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background-color: #ffffff;
            color: #374151;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .form-input.uppercase {
            text-transform: uppercase;
        }

        /* Icons */
        .input-icon,
        .select-icon,
        .textarea-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #9ca3af;
        }

        .textarea-icon {
            top: 1.25rem;
            transform: none;
        }

        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
        }

        .error-message::before {
            content: '⚠️';
            margin-right: 0.25rem;
        }

        /* Form Hints */
        .form-hint {
            color: #6b7280;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* File Upload */
        .file-upload-card {
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background-color: #f9fafb;
        }

        .file-upload-card:hover {
            border-color: #3b82f6;
            background-color: #f0f7ff;
        }

        .file-upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Photo Preview */
        .photo-preview {
            width: 100%;
            max-width: 240px;
            height: 140px;
            object-fit: cover;
        }

        .photo-badge {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            background-color: #10b981;
            color: white;
            font-size: 0.625rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            border: 1px solid transparent;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        .btn-secondary {
            background-color: white;
            color: #4b5563;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            transform: translateY(-1px);
        }

        .btn-secondary:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(209, 213, 219, 0.5);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-section {
                padding: 1rem;
            }

            .file-upload-card {
                padding: 1.5rem;
            }
        }

        /* Animations */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-4px);
            }

            40%,
            80% {
                transform: translateX(4px);
            }
        }

        .form-input.error:focus,
        .form-select.error:focus,
        .form-textarea.error:focus {
            animation: shake 0.3s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Image Preview Function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('preview-image');
                    preview.src = e.target.result;
                    document.getElementById('new-photo-preview').classList.remove('hidden');

                    // Auto-resize the preview container
                    const img = new Image();
                    img.onload = function() {
                        const aspectRatio = img.width / img.height;
                        const previewContainer = document.getElementById('new-photo-preview');
                        previewContainer.style.width = '100%';
                        previewContainer.style.maxWidth = '240px';
                    };
                    img.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove Preview Function
        function removePreview() {
            document.getElementById('photo').value = '';
            document.getElementById('new-photo-preview').classList.add('hidden');
        }

        // Form Validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const requiredFields = form.querySelectorAll('[required]');

            // Real-time validation
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    validateField(this);
                });

                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('error');
                    }
                });
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!validateField(field)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = form.querySelector('.error');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }
                }
            });

            function validateField(field) {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    return false;
                } else {
                    field.classList.remove('error');
                    return true;
                }
            }

            // Plate number validation
            const plateCategory = document.getElementById('plate_category');
            const plateNumber = document.getElementById('plate_number');

            if (plateCategory) {
                plateCategory.addEventListener('input', function() {
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                });
            }

            if (plateNumber) {
                plateNumber.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
        });
    </script>
@endpush
