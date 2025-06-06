<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'نظام إدارة العقارات') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-100 via-blue-50 to-cyan-100 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-10 text-center space-y-6">

        {{-- ✅ لوجو وعنوان --}}
        <div>
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-3">
            <h1 class="text-3xl font-bold text-gray-800">{{ config('CORVITA', 'CORVITA') }}</h1>
            <p class="text-gray-600 mt-2">نظام متكامل لإدارة العقارات والعمليات اليومية.</p>
        </div>

        {{-- ✅ مميزات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700">
            <div class="bg-blue-50 p-4 rounded-lg shadow-inner">
                🏢 إدارة المباني والوحدات
            </div>
            <div class="bg-green-50 p-4 rounded-lg shadow-inner">
                👥 تتبع المستأجرين والعقود
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg shadow-inner">
                💰 تحصيل الإيجارات بذكاء
            </div>
            <div class="bg-purple-50 p-4 rounded-lg shadow-inner">
                🛠️ طلبات الصيانة ومتابعتها
            </div>
        </div>

        {{-- ✅ أزرار --}}
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="{{ route('login') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-lg shadow transition duration-200">
                تسجيل الدخول
            </a>

            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline self-center">
                دخول مباشر للنظام
            </a>
        </div>

        {{-- ✅ Footer --}}
        <footer class="bg-gray-100 text-center py-6 mt-12 text-sm text-gray-500 border-t">
            &copy; {{ date('Y') }} All rights reserved to
            <strong class="text-gray-700">Corvita.net</strong>.
            Developed by
            <a href="https://wa.me/971503660507" target="_blank" class="font-semibold text-blue-600 hover:underline">
                Amr Mohammed
            </a>.
        </footer>




    </div>
</body>

</html>
