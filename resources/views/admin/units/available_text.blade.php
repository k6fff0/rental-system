@extends('layouts.app')

@section('content')
    <style>
        /* تحسينات عامة للصفحة */
        :root {
            --primary-bg: #ffffff;
            --secondary-bg: #f9fafb;
            --content-bg: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --border-color: #e5e7eb;
            --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 4px 15px rgba(0, 0, 0, 0.1);
            --blue-primary: #3b82f6;
            --blue-hover: #2563eb;
            --green-success: #10b981;
            --transition: all 0.3s ease;
        }

        [data-theme="dark"] {
            --primary-bg: #0f172a;
            --secondary-bg: #1e293b;
            --content-bg: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #475569;
            --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.3);
            --shadow-medium: 0 4px 15px rgba(0, 0, 0, 0.4);
            --blue-primary: #60a5fa;
            --blue-hover: #3b82f6;
            --green-success: #34d399;
        }

        * {
            transition: var(--transition);
        }

        body {
            font-family: 'Tajawal', 'Segoe UI', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: var(--primary-bg);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
        }

        /* تحسينات للهاتف */
        @media (max-width: 640px) {
            .responsive-padding {
                padding: 12px;
            }

            .responsive-text {
                font-size: 0.875rem;
            }

            .responsive-heading {
                font-size: 1.25rem;
            }

            .mobile-stack {
                flex-direction: column;
                align-items: stretch;
            }

            .mobile-full-width {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .responsive-padding {
                padding: 8px;
            }

            .responsive-text {
                font-size: 0.8rem;
            }

            .responsive-heading {
                font-size: 1.1rem;
            }
        }

        /* تحسينات منطقة النص */
        .content-box {
            border-radius: 16px;
            box-shadow: var(--shadow-medium);
            background-color: var(--content-bg);
            direction: rtl;
            line-height: 1.8;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        /* تحسينات الأزرار */
        .copy-btn {
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
            background-color: var(--blue-primary);
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .copy-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.4);
            background-color: var(--blue-hover);
        }

        .copy-btn:active {
            transform: translateY(0);
        }

        .theme-toggle {
            background-color: var(--secondary-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            font-family: inherit;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background-color: var(--content-bg);
            transform: translateY(-1px);
        }

        /* تحسينات التكست اريا */
        .custom-textarea {
            resize: none;
            border: none;
            background-color: transparent;
            font-family: 'Courier New', Courier, monospace;
            line-height: 1.9;
            padding: 20px;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .custom-textarea:focus {
            outline: none;
        }

        /* تحسينات للتاريخ */
        .date-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* تحسينات الهيدر */
        .header-container {
            background-color: var(--secondary-bg);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        .main-title {
            color: var(--text-primary);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        /* تحسين الخطوط للعربية */
        .arabic-text {
            font-family: 'Tajawal', 'Amiri', 'Noto Sans Arabic', sans-serif;
        }

        /* تحسين الانتقال السلس */
        .smooth-transition {
            transition: var(--transition);
        }

        /* تحسين الاسكرول */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: var(--secondary-bg);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        /* تحسينات للأيقونات */
        .icon {
            font-size: 1.2em;
            opacity: 0.9;
        }

        /* تحسين الفواصل */
        .divider {
            border-top: 2px solid var(--border-color);
            margin: 10px 0;
            opacity: 0.5;
        }

        /* تأثيرات بصرية */
        .glass-effect {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* تحسين الاستجابة للشاشات الصغيرة جداً */
        @media (max-width: 360px) {
            .responsive-padding {
                padding: 6px;
            }

            .header-container {
                padding: 12px;
            }

            .custom-textarea {
                padding: 12px;
                font-size: 0.75rem;
            }
        }

        /* تحسين للشاشات الكبيرة */
        @media (min-width: 1024px) {
            .desktop-enhance {
                max-width: 1200px;
            }

            .custom-textarea {
                font-size: 1rem;
                padding: 24px;
            }
        }

        /* انيميشن للنسخ الناجح */
        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-animation {
            animation: successPulse 0.6s ease-in-out;
        }
    </style>

    <div class="min-h-screen smooth-transition responsive-padding arabic-text">
        <div class="max-w-4xl desktop-enhance mx-auto">
            <!-- الهيدر -->
            <div class="header-container">
                <div class="flex flex-col sm:flex-row mobile-stack justify-between items-start sm:items-center gap-4">
                    <h2 class="main-title responsive-heading">
                        <span class="icon">🏠</span>
                        <span>النسخة الكتابية للغرف المتاحة</span>
                    </h2>

                    <div class="flex gap-3 mobile-full-width">
                        <button onclick="toggleTheme()"
                            class="theme-toggle px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 smooth-transition">
                            <span id="themeIcon">🌙</span>
                            <span id="themeText">الوضع الليلي</span>
                        </button>

                        <button onclick="copyToClipboard()"
                            class="copy-btn text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
                            <span id="copyIcon">📋</span>
                            <span id="copyText">نسخ كل النص</span>
                        </button>
                    </div>
                </div>

                <!-- التاريخ -->
                <div class="date-text mt-3">
                    <span class="icon">🕐</span>
                    <span>تم التحديث بتاريخ: {{ now()->format('Y-m-d H:i') }}</span>
                </div>
            </div>

            <!-- محتوى الغرف -->
            <div class="content-box custom-scrollbar smooth-transition"
                style="height: calc(100vh - 240px); min-height: 400px;">
                <textarea id="textContent" class="custom-textarea w-full h-full focus:outline-none smooth-transition" readonly>
@foreach ($units as $buildingName => $buildingUnits)
@php
    $building = $buildingUnits->first()->building;
@endphp

🏠 {{ $buildingName }} @if ($building->families_only)
(عائلات فقط \ Only Families)
@endif

@foreach ($building->supervisors as $supervisor)
👤 مسئول الفيلا: {{ $supervisor->name }} 
📞 الهاتف: {{ $supervisor->phone }}
@endforeach

@foreach ($buildingUnits as $unit)
🛏 غرفة رقم: {{ $unit->unit_number }}
🏷️ النوع: {{ __('messages.' . $unit->unit_type) }}
💵 الإيجار: {{ $unit->rent_price }} درهم
@if ($unit->location)
📍 الموقع: {{ __('messages.' . $unit->location) }}
@endif
@if ($unit->floor)
🏢 الطابق: {{ __('messages.floor_' . $unit->floor) }}
@endif

    ─────────────────────────────
@endforeach
@endforeach


                </textarea>
            </div>
        </div>
    </div>

    <script>
        // إدارة الوضع الليلي
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            updateThemeButton(newTheme);
        }

        function updateThemeButton(theme) {
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');

            if (theme === 'dark') {
                themeIcon.textContent = '☀️';
                themeText.textContent = 'الوضع النهاري';
            } else {
                themeIcon.textContent = '🌙';
                themeText.textContent = 'الوضع الليلي';
            }
        }

        // تحميل الوضع المحفوظ
        function loadSavedTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeButton(savedTheme);
        }

        // نسخ النص
        function copyToClipboard() {
            const textarea = document.getElementById("textContent");
            const copyIcon = document.getElementById("copyIcon");
            const copyText = document.getElementById("copyText");
            const copyBtn = document.querySelector('.copy-btn');

            textarea.select();
            textarea.setSelectionRange(0, 99999);

            try {
                document.execCommand("copy");

                // إضافة انيميشن النجاح
                copyBtn.classList.add('success-animation');

                // تغيير نص الزر مؤقتًا للإشارة إلى النجاح
                copyIcon.textContent = '✅';
                copyText.textContent = 'تم النسخ بنجاح!';
                copyBtn.style.backgroundColor = 'var(--green-success)';

                setTimeout(() => {
                    copyIcon.textContent = '📋';
                    copyText.textContent = 'نسخ كل النص';
                    copyBtn.style.backgroundColor = 'var(--blue-primary)';
                    copyBtn.classList.remove('success-animation');
                }, 2500);

            } catch (err) {
                // في حالة الخطأ
                copyIcon.textContent = '❌';
                copyText.textContent = 'فشل النسخ';

                setTimeout(() => {
                    copyIcon.textContent = '📋';
                    copyText.textContent = 'نسخ كل النص';
                }, 2000);

                console.error('خطأ في النسخ:', err);
            }
        }

        // تعديل ارتفاع منطقة النص
        function adjustLayout() {
            const windowHeight = window.innerHeight;
            const headerHeight = document.querySelector('.header-container').offsetHeight;
            const padding = 60; // مساحة إضافية للتباعد

            const contentHeight = Math.max(400, windowHeight - headerHeight - padding);
            document.querySelector('.content-box').style.height = `${contentHeight}px`;
        }

        // تحسين الأداء مع debouncing
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // الأحداث
        window.addEventListener('resize', debounce(adjustLayout, 100));
        document.addEventListener('DOMContentLoaded', () => {
            loadSavedTheme();
            adjustLayout();
        });

        // تحسين تجربة المستخدم على الموبايل
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }

        // منع التكبير المزدوج على iOS
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
@endsection
