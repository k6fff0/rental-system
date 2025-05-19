@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4 sm:px-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    {{-- 🏆 عنوان الصفحة مع أيقونة الحماية --}}
    <div class="flex items-center justify-between mb-8 border-b pb-4">
        <h1 class="text-2xl font-bold text-red-700 dark:text-red-400 flex items-center">
            🛡️ لوحة مالك النظام
        </h1>
        <span class="text-sm bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full">
            Super Admin Only
        </span>
    </div>

    {{-- 🔢 إحصائيات النظام --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <!-- بطاقة المستخدمين -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">المستخدمين</p>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $usersCount }}</h2>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                عرض الكل →
            </a>
        </div>

        <!-- بطاقة المباني -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">المباني</p>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $buildingsCount }}</h2>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.buildings.index') }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                عرض الكل →
            </a>
        </div>

        <!-- بطاقة الوحدات -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">الوحدات</p>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $unitsCount }}</h2>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.units.index') }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                عرض الكل →
            </a>
        </div>

        <!-- بطاقة العقود -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">العقود</p>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $contractsCount }}</h2>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900 p-2 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.contracts.index') }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                عرض الكل →
            </a>
        </div>
    </div>

    {{-- 📊 قسم التحكم السريع --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- بطاقة الأدوار والصلاحيات -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">👑 الأدوار والصلاحيات</h3>
                <a href="{{ route('admin.roles.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">إدارة الكل</a>
            </div>
            
            <div class="space-y-3">
                @foreach($roles as $role)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                    <div>
                        <span class="font-medium">{{ $role->name }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $role->users_count }} مستخدم</span>
                    </div>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">تعديل</a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- بطاقة النسخ الاحتياطي -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">💾 النسخ الاحتياطي</h3>
                <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded">
                    آخر نسخة: {{ $lastBackup ?? 'غير متاح' }}
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <button onclick="createBackup()" class="flex items-center justify-center gap-2 p-3 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    إنشاء نسخة
                </button>
                
                <button onclick="restoreBackup()" class="flex items-center justify-center gap-2 p-3 bg-green-600 hover:bg-green-700 text-white rounded transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    استعادة نسخة
                </button>
                
                <button onclick="downloadBackup()" class="flex items-center justify-center gap-2 p-3 bg-purple-600 hover:bg-purple-700 text-white rounded transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    تحميل نسخة
                </button>
                
                <button onclick="cleanupBackups()" class="flex items-center justify-center gap-2 p-3 bg-red-600 hover:bg-red-700 text-white rounded transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    حذف القديمة
                </button>
            </div>
        </div>
    </div>

    {{-- 📜 سجلات النظام --}}
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                📜 سجلات النظام
                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">
                    آخر 100 حدث
                </span>
            </h3>
            <div class="flex gap-2">
                <button onclick="clearLogs()" class="text-sm bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded hover:bg-red-200 dark:hover:bg-red-800 transition">
                    مسح السجلات
                </button>
                <button onclick="downloadLogs()" class="text-sm bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                    تحميل السجلات
                </button>
            </div>
        </div>

        @if (!empty($lastLog))
            <pre class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-sm overflow-auto max-h-[400px] whitespace-pre-wrap text-gray-800 dark:text-gray-100 font-mono">
{{ $lastLog }}
            </pre>
        @else
            <div class="p-4 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded">
                ⚠️ لا يوجد سجلات نظام حالياً.
            </div>
        @endif
    </div>

    {{-- ⚙️ الإعدادات المتقدمة --}}
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">⚙️ الإعدادات المتقدمة</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- وضع الصيانة -->
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                <div>
                    <p class="font-medium">وضع الصيانة</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">إيقاف النظام للزوار</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" id="maintenanceToggle" {{ app()->isDownForMaintenance() ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <!-- تنظيف الذاكرة المؤقتة -->
            <button onclick="clearCache()" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <div>
                    <p class="font-medium">تنظيف الذاكرة المؤقتة</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">مسح جميع البيانات المؤقتة</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>

            <!-- تحسين قاعدة البيانات -->
            <button onclick="optimizeDatabase()" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <div>
                    <p class="font-medium">تحسين قاعدة البيانات</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">تحسين أداء الجداول</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>

            <!-- إعادة تشغيل قوائم الانتظار -->
            <button onclick="restartQueue()" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <div>
                    <p class="font-medium">إعادة تشغيل قوائم الانتظار</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">إعادة تشغيل العاملين</p>
                </div>
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
// وظائف JavaScript للوظائف الإدارية
function createBackup() {
    // كود إنشاء النسخ الاحتياطي
    alert('جاري إنشاء نسخة احتياطية...');
    // يمكنك استخدام AJAX لاستدعاء route معين في Laravel
}

function restoreBackup() {
    // كود استعادة النسخ الاحتياطي
    alert('جاري استعادة النسخة الاحتياطية...');
}

function downloadBackup() {
    // كود تحميل النسخ الاحتياطي
    alert('جاري تحميل النسخة الاحتياطية...');
}

function cleanupBackups() {
    // كود حذف النسخ القديمة
    alert('جاري حذف النسخ الاحتياطية القديمة...');
}

function clearLogs() {
    // كود مسح سجلات النظام
    if(confirm('هل أنت متأكد من رغبتك في مسح جميع سجلات النظام؟')) {
        alert('جاري مسح السجلات...');
    }
}

function downloadLogs() {
    // كود تحميل السجلات
    alert('جاري تحميل سجلات النظام...');
}

function clearCache() {
    // كود مسح الذاكرة المؤقتة
    alert('جاري مسح الذاكرة المؤقتة...');
}

function optimizeDatabase() {
    // كود تحسين قاعدة البيانات
    alert('جاري تحسين قاعدة البيانات...');
}

function restartQueue() {
    // كود إعادة تشغيل قوائم الانتظار
    alert('جاري إعادة تشغيل قوائم الانتظار...');
}

// التحكم في وضع الصيانة
document.getElementById('maintenanceToggle').addEventListener('change', function() {
    if(this.checked) {
        if(confirm('هل تريد تفعيل وضع الصيانة؟ هذا سيغلق النظام أمام جميع الزوار.')) {
            // تفعيل وضع الصيانة
            alert('جاري تفعيل وضع الصيانة...');
        } else {
            this.checked = false;
        }
    } else {
        // إيقاف وضع الصيانة
        alert('جاري إيقاف وضع الصيانة...');
    }
});
</script>
@endsection