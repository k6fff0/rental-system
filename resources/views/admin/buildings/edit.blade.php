@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-6" dir="rtl">

        {{-- 🔹 عنوان الصفحة --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h2l1 2h13l1-2h2m-6 2v4m-4-4v4m-4-4v4m8-10V4a1 1 0 00-1-1H7a1 1 0 00-1 1v4" />
                </svg>
                تعديل بيانات المبنى
            </h1>
            <a href="{{ route('admin.buildings.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors duration-150">

                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2 transform rotate-180' }}"
                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd"></path>
                </svg>

                {{ __('messages.back_to_buildings') }}
            </a>

        </div>

        {{-- 🔧 الفورم --}}
        <div class="bg-white p-8 rounded-xl shadow space-y-8 border border-gray-100">

            <form action="{{ route('admin.buildings.update', $building->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- اسم المبنى --}}
                    <div>
                        <label for="name" class="block mb-1 text-sm font-semibold text-gray-700">اسم المبنى</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $building->name) }}"
                            class="form-input w-full rounded-md shadow-sm focus:ring focus:ring-green-200" required>
                    </div>

                    {{-- رقم المبنى --}}
                    <div>
                        <label for="building_number" class="block mb-1 text-sm font-semibold text-gray-700">رقم
                            المبنى</label>
                        <input type="text" name="building_number" id="building_number"
                            value="{{ old('building_number', $building->building_number) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- العنوان --}}
                    <div>
                        <label for="address" class="block mb-1 text-sm font-semibold text-gray-700">العنوان</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $building->address) }}"
                            class="form-input w-full rounded-md shadow-sm" required>
                    </div>

                    {{-- رابط جوجل ماب --}}
                    <div>
                        <label for="location_url" class="block mb-1 text-sm font-semibold text-gray-700">رابط Google
                            Maps</label>
                        <input type="url" name="location_url" id="location_url"
                            value="{{ old('location_url', $building->location_url) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- اسم المالك --}}
                    <div>
                        <label for="owner_name" class="block mb-1 text-sm font-semibold text-gray-700">اسم المالك</label>
                        <input type="text" name="owner_name" id="owner_name"
                            value="{{ old('owner_name', $building->owner_name) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- الجنسية --}}
                    <div>
                        <label for="owner_nationality"
                            class="block mb-1 text-sm font-semibold text-gray-700">الجنسية</label>
                        <input type="text" name="owner_nationality" id="owner_nationality"
                            value="{{ old('owner_nationality', $building->owner_nationality) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- رقم الهوية --}}
                    <div>
                        <label for="owner_id_number" class="block mb-1 text-sm font-semibold text-gray-700">رقم
                            الهوية</label>
                        <input type="text" name="owner_id_number" id="owner_id_number"
                            value="{{ old('owner_id_number', $building->owner_id_number) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- رقم الموبايل --}}
                    <div>
                        <label for="owner_phone" class="block mb-1 text-sm font-semibold text-gray-700">رقم الموبايل</label>
                        <input type="text" name="owner_phone" id="owner_phone"
                            value="{{ old('owner_phone', $building->owner_phone) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- رقم تسجيل البلدية --}}
                    <div>
                        <label for="municipality_number" class="block mb-1 text-sm font-semibold text-gray-700">رقم تسجيل
                            البلدية</label>
                        <input type="text" name="municipality_number" id="municipality_number"
                            value="{{ old('municipality_number', $building->municipality_number) }}"
                            class="form-input w-full rounded-md shadow-sm">
                    </div>

                    {{-- سعر الإيجار --}}
                    <div>
                        <label for="rent_amount" class="block mb-1 text-sm font-semibold text-gray-700">سعر الإيجار
                            (شهريًا)</label>
                        <input type="number" name="rent_amount" id="rent_amount"
                            value="{{ old('rent_amount', $building->rent_amount) }}"
                            class="form-input w-full rounded-md shadow-sm" step="0.01">
                    </div>

                    {{-- التعديل الأولي --}}
                    <div>
                        <label for="initial_renovation_cost" class="block mb-1 text-sm font-semibold text-gray-700">تكاليف
                            التعديل لأول مرة</label>
                        <input type="number" name="initial_renovation_cost" id="initial_renovation_cost"
                            value="{{ old('initial_renovation_cost', $building->initial_renovation_cost) }}"
                            class="form-input w-full rounded-md shadow-sm" step="0.01">
                    </div>

                </div>

                {{-- زر الحفظ --}}
                <div class="mt-8 text-left">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ التعديلات
                    </button>
                </div>
            </form>

            {{-- Toggle العائلات فقط --}}
            <div class="border-t pt-6">
                <form action="{{ route('admin.buildings.toggleFamiliesOnly', $building->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="w-12 h-6 rounded-full p-0 border-none focus:outline-none focus:ring-2 focus:ring-green-500 transition {{ $building->families_only ? 'bg-green-500' : 'bg-gray-300' }}">
                            <span class="sr-only">{{ __('messages.toggle') }}</span>
                            <span aria-hidden="true"
                                class="{{ $building->families_only ? 'ml-auto' : 'mr-auto' }} block h-5 w-5 rounded-full bg-white shadow transform transition-all duration-200"></span>
                        </button>
                        <span class="text-sm text-gray-700">
                            {{ $building->families_only ? __('messages.only_families_enabled') : __('messages.families_and_individuals') }}
                        </span>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
