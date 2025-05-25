@extends('layouts.app')

@section('title', 'تعديل إعدادات النظام')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
        <i class="fas fa-cogs text-yellow-500"></i>
        إعدادات النظام
    </h1>

    @if (session('success'))
        <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="mb-6 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ url('admin/update') }}" enctype="multipart/form-data">
        @csrf

        {{-- 🔤 اسم التطبيق --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم التطبيق</label>
            <input type="text" name="app_name" value="{{ settings()->app_name ?? config('app.name') }}"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-gray-100">
        </div>

        {{-- 🎨 اللون الأساسي --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اللون الأساسي</label>
            <input type="color" name="primary_color" value="{{ settings()->primary_color ?? '#000000' }}"
                class="w-24 h-10 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100">
        </div>

        {{-- 🖼️ الشعار --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">شعار النظام</label>
            <input type="file" name="app_logo" accept="image/*"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-gray-100">

            @if (settings()->app_logo)
                <div class="mt-3 flex items-center gap-4">
                    <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Logo" class="h-16 rounded-md shadow border border-gray-200 dark:border-gray-600">
                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <input type="hidden" name="remove_logo" value="0">
                        <input type="checkbox" name="remove_logo" value="1">
                        حذف الشعار الحالي
                    </label>
                </div>
            @endif
        </div>

        {{-- 🌐 Favicon --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Favicon (الأيقونة الصغيرة)</label>
            <input type="file" name="favicon" accept="image/x-icon,image/png"
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-gray-100">

            @if (settings()->favicon)
                <div class="mt-3 flex items-center gap-4">
                    <img src="{{ asset('storage/' . settings()->favicon) }}" alt="Favicon" class="h-8 w-8 rounded shadow border border-gray-200 dark:border-gray-600">
                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <input type="hidden" name="remove_favicon" value="0">
                        <input type="checkbox" name="remove_favicon" value="1">
                        حذف الأيقونة الحالية
                    </label>
                </div>
            @endif
        </div>

        {{-- ⚙️ وضع الصيانة --}}
        <div class="mb-6 flex items-center gap-3">
            <input type="hidden" name="maintenance_mode" value="0">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer"
                    {{ settings()->maintenance_mode ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"></div>
            </label>
            <span class="text-sm text-gray-700 dark:text-gray-300">تفعيل وضع الصيانة</span>
        </div>

        {{-- 💾 زر الحفظ --}}
        <div class="mt-6">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow text-sm font-semibold transition-colors duration-200">
                <i class="fas fa-save mr-2"></i>
                حفظ الإعدادات
            </button>
        </div>
    </form>
</div>
@endsection
