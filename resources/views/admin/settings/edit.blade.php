@extends('layouts.app')

@section('title', 'تعديل إعدادات النظام')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
            <i class="fas fa-cogs text-yellow-500"></i>
            إعدادات النظام
        </h1>

        @if (session('success'))
            <div
                class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div
                class="mb-6 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- 🔤 اسم النظام --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم النظام</label>
                <input type="text" name="app_name" value="{{ old('app_name', settings()->app_name) }}"
                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white">
            </div>

            {{-- 📧 البريد العام للنظام --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البريد الإلكتروني
                    للنظام</label>
                <input type="email" name="system_email" value="{{ old('system_email', settings()->system_email) }}"
                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white">
            </div>

            {{-- 🎨 اللون الأساسي --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"></label>
                <input type="hidden" name="primary_color" value="{{ settings()->primary_color }}">
            </div>

            {{-- 🌈 اللون الثانوي --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"></label>
                <input type="hidden" name="secondary_color" value="{{ settings()->secondary_color }}">
            </div>

            {{-- 🖼️ شعار النظام --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">شعار النظام</label>
                <input type="file" name="app_logo" accept="image/*" class="block w-full text-sm">

                @if (settings()->app_logo)
                    <div class="mt-2 flex items-center gap-4">
                        <img src="{{ Storage::url(settings()->app_logo) }}" class="h-12 rounded shadow border">
                        <label class="flex items-center gap-2 text-sm text-red-600">
                            <input type="hidden" name="remove_logo" value="0">
                            <input type="checkbox" name="remove_logo" value="1">
                            حذف الشعار الحالي
                        </label>
                    </div>
                @endif
            </div>

            {{-- 🌐 Favicon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Favicon</label>
                <input type="file" name="favicon" accept="image/x-icon,image/png" class="block w-full text-sm">

                @if (settings()->favicon)
                    <div class="mt-2 flex items-center gap-4">
                        <img src="{{ Storage::url(settings()->favicon) }}" class="h-8 w-8 border rounded shadow">
                        <label class="flex items-center gap-2 text-sm text-red-600">
                            <input type="hidden" name="remove_favicon" value="0">
                            <input type="checkbox" name="remove_favicon" value="1">
                            حذف الأيقونة الحالية
                        </label>
                    </div>
                @endif
            </div>

            {{-- 📝 شروط العقد الافتراضية --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">شروط العقد الافتراضية</label>
                <textarea name="default_contract_terms" rows="4"
                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white">{{ old('default_contract_terms', settings()->default_contract_terms) }}</textarea>
            </div>

            {{-- 🚧 وضع الصيانة --}}
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    <input type="hidden" name="maintenance_mode" value="{{ settings()->maintenance_mode }}">

                </label>
            </div>

            {{-- 💾 زر الحفظ --}}
            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    💾 حفظ التعديلات
                </button>
            </div>
        </form>

    </div>
@endsection
