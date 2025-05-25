@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    {{-- 🏆 عنوان الصفحة --}}
    <div class="flex items-center justify-between mb-8 border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="fas fa-shield-alt text-red-500"></i>
            لوحة مالك النظام
        </h1>
        <span class="text-sm bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full">
            صلاحيات كاملة
        </span>
    </div>

    {{-- 🔢 إحصائيات النظام --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['title' => 'المستخدمين', 'count' => $usersCount, 'icon' => 'users', 'color' => 'blue', 'route' => 'admin.users.index'],
            ['title' => 'المباني', 'count' => $buildingsCount, 'icon' => 'building', 'color' => 'green', 'route' => 'admin.buildings.index'],
            ['title' => 'الوحدات', 'count' => $unitsCount, 'icon' => 'home', 'color' => 'purple', 'route' => 'admin.units.index'],
            ['title' => 'العقود', 'count' => $contractsCount, 'icon' => 'file-contract', 'color' => 'yellow', 'route' => 'admin.contracts.index']
        ] as $stat)
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stat['title'] }}</p>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $stat['count'] }}</h2>
                </div>
                <div class="p-2 rounded-full" style="background-color: {{ settings()->primary_color }}20;">
                    <i class="fas fa-{{ $stat['icon'] }}" style="color: {{ settings()->primary_color }}"></i>
                </div>
            </div>
            <a href="{{ route($stat['route']) }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                عرض الكل →
            </a>
        </div>
        @endforeach
    </div>

    {{-- 📊 قسم التحكم السريع --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- بطاقة الأدوار والصلاحيات -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="fas fa-user-shield text-purple-500"></i>
                    الأدوار والصلاحيات
                </h3>
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
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="fas fa-cloud text-blue-500"></i>
                    النسخ الاحتياطي
                </h3>
                <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded">
                    آخر نسخة: {{ $lastBackup ? $lastBackup->format('Y-m-d H:i') : 'غير متاح' }}
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <form method="POST" action="{{ route('admin.backup.create') }}" class="contents">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 p-3 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                        <i class="fas fa-save"></i>
                        إنشاء نسخة
                    </button>
                </form>
                
                <button onclick="showRestoreModal()" class="flex items-center justify-center gap-2 p-3 bg-green-600 hover:bg-green-700 text-white rounded transition">
                    <i class="fas fa-history"></i>
                    استعادة نسخة
                </button>
                
                <form method="POST" action="{{ route('admin.backup.download') }}" class="contents">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 p-3 bg-purple-600 hover:bg-purple-700 text-white rounded transition">
                        <i class="fas fa-download"></i>
                        تحميل نسخة
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.backup.clean') }}" class="contents">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 p-3 bg-red-600 hover:bg-red-700 text-white rounded transition">
                        <i class="fas fa-trash"></i>
                        حذف القديمة
                    </button>
                </form>
            </div>
        </div>

        <!-- بطاقة إعدادات النظام -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="fas fa-cogs text-yellow-500"></i>
                    إعدادات النظام
                </h3>
                <a href="{{ route('admin.settings.edit') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">تعديل الكل</a>
            </div>
            
            <div class="space-y-3">
                @foreach([
                    ['key' => 'app_name', 'label' => 'اسم التطبيق', 'value' => settings('app_name', config('app.name'))],
                    ['key' => 'app_logo', 'label' => 'شعار النظام', 'value' => settings('app_logo') ? 'مضبوط' : 'غير مضبوط'],
                    ['key' => 'primary_color', 'label' => 'اللون الأساسي', 'value' => settings('primary_color', '#3b82f6')],
                    ['key' => 'maintenance_mode', 'label' => 'وضع الصيانة', 'value' => settings('maintenance_mode', false) ? 'مفعل' : 'معطل']
                ] as $setting)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                    <div>
                        <span class="font-medium">{{ $setting['label'] }}</span>
                        <span class="text-xs text-gray-500 ml-2">
                           {{ is_string($setting['value']) ? $setting['value'] : (is_bool($setting['value']) ? ($setting['value'] ? 'مفعل' : 'معطل') : '') }}
                        </span>

                    </div>
                    <a href="{{ route('admin.settings.edit', ['setting' => $setting['key']]) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">تعديل</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 📜 سجلات النظام --}}
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-gray-500"></i>
                سجلات النظام
                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">
                    آخر 100 حدث
                </span>
            </h3>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.logs.clear') }}" class="contents">
                    @csrf
                    <button type="submit" onclick="return confirm('هل أنت متأكد من رغبتك في مسح جميع سجلات النظام؟')" class="text-sm bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded hover:bg-red-200 dark:hover:bg-red-800 transition">
                        مسح السجلات
                    </button>
                </form>
                <a href="{{ route('admin.logs.download') }}" class="text-sm bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                    تحميل السجلات
                </a>
            </div>
        </div>

        @if (!empty($logs))
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded text-sm overflow-auto max-h-[400px] font-mono">
                @foreach($logs as $log)
                <div class="py-1 border-b border-gray-200 dark:border-gray-600 last:border-0">
                    <div class="flex items-baseline gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $log['date'] }}</span>
                        <span class="text-xs px-1 rounded 
                            @if(str_contains($log['level'], 'ERROR')) bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                            @elseif(str_contains($log['level'], 'WARNING')) bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                            @else bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                            @endif">
                            {{ $log['level'] }}
                        </span>
                    </div>
                    <p class="text-gray-800 dark:text-gray-100 mt-1">{{ $log['message'] }}</p>
                </div>
                @endforeach
            </div>
        @else
            <div class="p-4 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded">
                ⚠️ لا يوجد سجلات نظام حالياً.
            </div>
        @endif
    </div>

    {{-- 📝 إدارة العقود والشروط --}}
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="fas fa-file-contract text-indigo-500"></i>
                إدارة العقود والشروط
            </h3>
            <button onclick="showContractModal()" class="text-sm bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded hover:bg-green-200 dark:hover:bg-green-800 transition">
                إضافة عقد جديد
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">النوع</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">آخر تحديث</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($contractTypes as $type)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $type['name'] }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $type['updated_at'] ? $type['updated_at']->diffForHumans() : 'غير محدث' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $type['is_active'] ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                {{ $type['is_active'] ? 'مفعل' : 'معطل' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex gap-2">
                                <button onclick="editContract('{{ $type['key'] }}')" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="previewContract('{{ $type['key'] }}')" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.contracts.toggle', $type['key']) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ⚙️ الإعدادات المتقدمة --}}
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
            <i class="fas fa-sliders-h text-gray-500"></i>
            الإعدادات المتقدمة
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- وضع الصيانة -->
            <form method="POST" action="{{ route('admin.settings.maintenance') }}" class="contents">
                @csrf
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded">
                    <div>
                        <p class="font-medium">وضع الصيانة</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">إيقاف النظام للزوار</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" class="sr-only peer" 
                            {{ settings('maintenance_mode', false) ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </form>

            <!-- تنظيف الذاكرة المؤقتة -->
            <form method="POST" action="{{ route('admin.cache.clear') }}" class="contents">
                @csrf
                <button type="submit" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                    <div>
                        <p class="font-medium">تنظيف الذاكرة المؤقتة</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">مسح جميع البيانات المؤقتة</p>
                    </div>
                    <i class="fas fa-trash text-gray-500 dark:text-gray-400"></i>
                </button>
            </form>

            <!-- تحسين قاعدة البيانات -->
            <form method="POST" action="{{ route('admin.database.optimize') }}" class="contents">
                @csrf
                <button type="submit" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                    <div>
                        <p class="font-medium">تحسين قاعدة البيانات</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تحسين أداء الجداول</p>
                    </div>
                    <i class="fas fa-database text-gray-500 dark:text-gray-400"></i>
                </button>
            </form>

            <!-- إعادة تشغيل قوائم الانتظار -->
            <form method="POST" action="{{ route('admin.queue.restart') }}" class="contents">
                @csrf
                <button type="submit" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                    <div>
                        <p class="font-medium">إعادة تشغيل قوائم الانتظار</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">إعادة تشغيل العاملين</p>
                    </div>
                    <i class="fas fa-sync-alt text-gray-500 dark:text-gray-400"></i>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- مودال إضافة/تعديل العقد --}}
<div id="contractModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100" id="modalTitle">إضافة عقد جديد</h3>
                <button onclick="hideContractModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="contractForm" method="POST" action="{{ route('admin.contracts.store') }}">
                @csrf
                <input type="hidden" name="contract_key" id="contractKey">
                
                <div class="space-y-4">
                    <div>
                        <label for="contract_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم العقد</label>
                        <input type="text" name="contract_name" id="contract_name" required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="contract_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">محتوى العقد</label>
                        <textarea name="contract_content" id="contract_content" rows="10" required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">تفعيل هذا العقد</label>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hideContractModal()"
                        class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
                        إلغاء
                    </button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        حفظ العقد
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- مودال معاينة العقد --}}
<div id="previewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100" id="previewTitle">معاينة العقد</h3>
                <button onclick="hidePreviewModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="prose dark:prose-invert max-w-none" id="contractPreviewContent">
                {{-- سيتم ملء المحتوى هنا عبر JavaScript --}}
            </div>
            
            <div class="mt-6 flex justify-end">
                <button onclick="hidePreviewModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
</div>

{{-- مودال استعادة النسخة الاحتياطية --}}
<div id="restoreModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">استعادة نسخة احتياطية</h3>
                <button onclick="hideRestoreModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.backup.restore') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اختر ملف النسخة الاحتياطية</label>
                        <input type="file" name="backup_file" accept=".zip,.sql" required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="delete_existing" id="delete_existing"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                        <label for="delete_existing" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">حذف البيانات الحالية قبل الاستعادة</label>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hideRestoreModal()"
                        class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
                        إلغاء
                    </button>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        استعادة النسخة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// وظائف JavaScript للعقود
function showContractModal(contract = null) {
    const modal = document.getElementById('contractModal');
    const form = document.getElementById('contractForm');
    const title = document.getElementById('modalTitle');
    
    if (contract) {
        title.textContent = 'تعديل العقد';
        document.getElementById('contractKey').value = contract.key;
        document.getElementById('contract_name').value = contract.name;
        document.getElementById('contract_content').value = contract.content;
        document.getElementById('is_active').checked = contract.is_active;
        form.action = `/admin/contracts/${contract.id}`;
        form.method = "POST";
        // إضافة حقول الإدخال المخفية لطريقة PUT
        if (!form.querySelector('input[name="_method"]')) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        }
    } else {
        title.textContent = 'إضافة عقد جديد';
        form.reset();
        form.action = "{{ route('admin.contracts.store') }}";
        form.method = "POST";
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
    }
    
    modal.classList.remove('hidden');
}

function hideContractModal() {
    document.getElementById('contractModal').classList.add('hidden');
}

function editContract(key) {
    // هنا يمكنك جلب بيانات العقد عبر AJAX أو تمريرها مسبقًا
    const contract = {
        key: key,
        name: document.querySelector(`tr td:first-child`).textContent.trim(),
        content: '...', // يجب جلب المحتوى الفعلي من الخادم
        is_active: document.querySelector(`tr span.bg-green-100`) !== null
    };
    showContractModal(contract);
}

function previewContract(key) {
    const modal = document.getElementById('previewModal');
    const title = document.getElementById('previewTitle');
    const content = document.getElementById('contractPreviewContent');
    
    title.textContent = `معاينة العقد: ${key}`;
    
    // هنا يمكنك جلب محتوى العقد عبر AJAX
    fetch(`/admin/contracts/${key}/preview`)
        .then(response => response.json())
        .then(data => {
            content.innerHTML = data.content;
        })
        .catch(error => {
            content.innerHTML = `<p class="text-red-500">حدث خطأ أثناء جلب محتوى العقد</p>`;
        });
    
    modal.classList.remove('hidden');
}

function hidePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}

function showRestoreModal() {
    document.getElementById('restoreModal').classList.remove('hidden');
}

function hideRestoreModal() {
    document.getElementById('restoreModal').classList.add('hidden');
}
</script>
@endsection