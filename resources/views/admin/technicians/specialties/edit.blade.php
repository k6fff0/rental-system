@extends('layouts.app')

@section('title', 'تعديل التخصص')

@push('styles')
<style>
    /* Custom styles for a cleaner, modern look */
    .form-container {
        background-color: #ffffff;
        padding: 2.5rem; /* Increased padding */
        border-radius: 0.75rem; /* More rounded corners */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* Stronger, softer shadow */
        transition: all 0.3s ease-in-out;
    }

    .form-container:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12); /* Slightly more prominent shadow on hover */
    }

    .form-label {
        display: block;
        font-size: 0.95rem; /* Slightly larger label font */
        font-weight: 600; /* Medium bold */
        color: #333;
        margin-bottom: 0.5rem;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem 1rem; /* More vertical padding */
        border: 1px solid #d1d5db; /* Lighter border */
        border-radius: 0.5rem; /* Rounded input fields */
        font-size: 1rem;
        color: #374151;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-input:focus, .form-select:focus {
        border-color: #3b82f6; /* Blue border on focus */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); /* Blue glow on focus */
        outline: none;
    }

    .input-error {
        border-color: #ef4444; /* Red border for errors */
    }

    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .submit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #2563eb; /* Stronger blue */
        color: white;
        padding: 0.85rem 2rem; /* Larger padding for button */
        border-radius: 0.6rem;
        font-weight: 600;
        font-size: 1.05rem;
        transition: background-color 0.2s ease, transform 0.2s ease;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); /* Soft shadow */
    }

    .submit-button:hover {
        background-color: #1d4ed8; /* Darker blue on hover */
        transform: translateY(-1px); /* Slight lift effect */
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    .submit-button:disabled {
        background-color: #93c5fd; /* Lighter blue when disabled */
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .form-container {
            padding: 1.5rem;
            margin: 1.5rem auto;
        }
        .submit-button {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto form-container mt-10" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h2 class="text-3xl font-extrabold mb-8 text-center text-gray-800">
        {{ app()->getLocale() === 'ar' ? 'تعديل بيانات التخصص' : 'Edit Specialty Details' }}
        <span class="block text-blue-600 text-2xl mt-2">{{ $specialty->name }}</span>
    </h2>

    <form action="{{ route('admin.technicians.specialties.update', $specialty->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- اسم التخصص --}}
        <div class="mb-5">
            <label for="name" class="form-label">
                {{ app()->getLocale() === 'ar' ? 'اسم التخصص' : 'Specialty Name' }}
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $specialty->name) }}"
                   class="form-input @error('name') input-error @enderror"
                   placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: كهرباء، سباكة...' : 'e.g., Electrical, Plumbing...' }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- نوع التخصص --}}
        <div class="mb-5">
            <label for="is_main" class="form-label">
                {{ app()->getLocale() === 'ar' ? 'نوع التخصص' : 'Specialty Type' }}
            </label>
            <select name="is_main" id="is_main" class="form-select" onchange="toggleParentDropdown()">
                <option value="1" {{ $specialty->is_main ? 'selected' : '' }}>
                    {{ app()->getLocale() === 'ar' ? 'تخصص رئيسي' : 'Main Specialty' }}
                </option>
                <option value="0" {{ !$specialty->is_main ? 'selected' : '' }}>
                    {{ app()->getLocale() === 'ar' ? 'مهمة إضافية (تخصص فرعي)' : 'Sub Specialty (Additional Task)' }}
                </option>
            </select>
        </div>

        {{-- ينتمي إلى (التخصص الرئيسي) --}}
        <div class="mb-7" id="parentDropdown">
            <label for="parent_id" class="form-label">
                {{ app()->getLocale() === 'ar' ? 'ينتمي إلى (تخصص رئيسي)' : 'Belongs To (Main Specialty)' }}
            </label>
            <select name="parent_id" id="parent_id" class="form-select @error('parent_id') input-error @enderror">
                <option value="">
                    {{ app()->getLocale() === 'ar' ? '— اختر تخصص رئيسي —' : '— Select a main specialty —' }}
                </option>
                @foreach ($mainSpecialties as $main)
                    @if ($main->id != $specialty->id) {{-- منع ربط التخصص بنفسه كتخصص رئيسي --}}
                        <option value="{{ $main->id }}" {{ $specialty->parent_id == $main->id ? 'selected' : '' }}>
                            {{ $main->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('parent_id')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- زر حفظ التعديلات --}}
        <div class="text-center">
            <button type="submit" class="submit-button">
                <svg class="w-5 h-5 mr-2 {{ app()->getLocale() === 'ar' ? 'ml-2' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v6a2 2 0 002 2h3m0-7a4 4 0 118 0m0 7H21a2 2 0 002-2v-6a2 2 0 00-2-2h-3m-7 2h7m-7 7a2 2 0 01-2 2H5a2 2 0 01-2-2v-3m16 0v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3"></path></svg>
                {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}
            </button>
        </div>
    </form>
</div>

<script>
    function toggleParentDropdown() {
        const isMainSelect = document.getElementById('is_main');
        const parentDropdownDiv = document.getElementById('parentDropdown');
        
        // Show parentDropdown if 'مهمة إضافية' (Sub Specialty) is selected
        if (isMainSelect.value === '0') {
            parentDropdownDiv.style.display = 'block';
            parentDropdownDiv.querySelector('select').setAttribute('required', 'required'); // Make required when visible
        } else {
            parentDropdownDiv.style.display = 'none';
            parentDropdownDiv.querySelector('select').removeAttribute('required'); // Remove required when hidden
            parentDropdownDiv.querySelector('select').value = ''; // Clear selection when hidden
        }
    }

    // Call on page load to set initial state
    document.addEventListener('DOMContentLoaded', toggleParentDropdown);
</script>
@endsection