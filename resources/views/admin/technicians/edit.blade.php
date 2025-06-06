@extends('layouts.app')

@section('title', 'تعديل بيانات الفني')

@section('content')
    <div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-xl ring-1 ring-gray-200">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">تعديل بيانات الفني: <span
                    class="text-blue-600">{{ $technician->name }}</span></h2>

            <form action="{{ route('admin.technicians.update', $technician->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- التخصص الرئيسي --}}
                <div>
                    <label for="main_specialty_id" class="block text-sm font-semibold text-gray-700 mb-1">التخصص
                        الرئيسي</label>
                    <select name="main_specialty_id" id="main_specialty_id"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-2.5 px-3">
                        <option value="">— اختر تخصصاً —</option>
                        @foreach ($mainSpecialties as $main)
                            <option value="{{ $main->id }}"
                                {{ $technician->main_specialty_id == $main->id ? 'selected' : '' }}>
                                {{ $main->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- الحالة --}}
                <div>
                    <label for="technician_status" class="block text-sm font-semibold text-gray-700 mb-1">الحالة</label>
                    <select name="technician_status" id="technician_status"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-2.5 px-3">
                        <option value="available" {{ $technician->technician_status == 'available' ? 'selected' : '' }}>متاح
                        </option>
                        <option value="busy" {{ $technician->technician_status == 'busy' ? 'selected' : '' }}>مشغول
                        </option>
                        <option value="unavailable" {{ $technician->technician_status == 'unavailable' ? 'selected' : '' }}>
                            غير متاح</option>
                    </select>
                </div>

                {{-- الملاحظات --}}
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">ملاحظات</label>
                    <textarea name="notes" id="notes" rows="4"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm py-2 px-3">{{ $technician->notes }}</textarea>
                </div>

                <div class="pt-4 text-center">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
