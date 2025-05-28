@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">لوحة التحكم</h1>

        {{-- ✅ شبكة البطاقات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            
            {{-- 🟢 الغرف المتاحة --}}
            <a href="{{ route('admin.units.available') }}" class="block bg-green-100 hover:bg-green-200 text-green-800 rounded-xl p-6 shadow transition text-center">
                <div class="text-2xl font-bold mb-2">الغرف المتاحة</div>
                <div class="text-sm text-gray-600">عرض الوحدات الجاهزة للإيجار</div>
            </a>

            {{-- 🔵 Test --}}
            <div class="bg-blue-100 text-blue-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🟣 Test --}}
            <div class="bg-purple-100 text-purple-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🟠 Test --}}
            <div class="bg-orange-100 text-orange-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🔴 Test --}}
            <div class="bg-red-100 text-red-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🟤 Test --}}
            <div class="bg-yellow-100 text-yellow-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🧊 Test --}}
            <div class="bg-cyan-100 text-cyan-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🟪 Test --}}
            <div class="bg-indigo-100 text-indigo-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- ⚪ Test --}}
            <div class="bg-gray-100 text-gray-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

            {{-- 🟨 Test --}}
            <div class="bg-lime-100 text-lime-800 rounded-xl p-6 shadow text-center">
                <div class="text-2xl font-bold mb-2">Test</div>
                <div class="text-sm text-gray-600">رابط تجريبي</div>
            </div>

        </div>
    </div>
</div>
@endsection
