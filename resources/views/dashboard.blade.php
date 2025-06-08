<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الاختصارات - Shortcuts Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Inter:wght@300;400;500;600;700&display=swap');

        [dir="rtl"] {
            font-family: 'Cairo', sans-serif;
        }

        [dir="ltr"] {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .icon-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">
    <!-- Header with Language Toggle -->
    <header class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2" id="main-title">
                        لوحة الاختصارات السريعة
                    </h1>
                    <p class="text-blue-100 text-sm sm:text-base" id="main-subtitle">
                        الوصول السريع للمهام الأساسية في النظام
                    </p>
                </div>

                <!-- Language Toggle -->
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <button onclick="toggleLanguage()"
                        class="glassmorphism text-white px-4 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition-all duration-300 flex items-center space-x-2 rtl:space-x-reverse">
                        <i class="fas fa-globe text-sm"></i>
                        <span class="text-sm font-medium" id="lang-button">EN</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Dashboard -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Shortcuts Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <!-- Available Rooms -->
            <a href="{{ route('admin.units.available') }}"
                class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
                <div class="text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-home text-green-600 text-2xl icon-bounce"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2" id="available-rooms-title">الغرف المتاحة</h3>
                    <p class="text-sm text-gray-600" id="available-rooms-desc">عرض الوحدات الجاهزة للإيجار</p>
                    <div class="mt-4 text-xs text-green-600 font-medium">
                        <span id="quick-access">وصول سريع</span> →
                    </div>
                </div>
            </a>

            <!-- Book Room -->
            <a href="{{ route('admin.bookings.create') }}"
                class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
                <div class="text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-teal-200 transition-colors">
                        <i class="fas fa-bed text-teal-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2" id="book-room-title">حجز غرفة</h3>
                    <p class="text-sm text-gray-600" id="book-room-desc">إضافة حجز جديد لوحدة متاحة</p>
                    <div class="mt-4 text-xs text-teal-600 font-medium">
                        <span id="quick-access-2">وصول سريع</span> →
                    </div>
                </div>
            </a>
<!-- My Bookings -->
<a href="{{ route('admin.bookings.index', ['my' => true]) }}"
    class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
    <div class="text-center">
        <div
            class="mx-auto w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-gray-200 transition-colors">
            <i class="fas fa-calendar-check text-gray-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2" id="my-bookings-title">حجوزاتي</h3>
        <p class="text-sm text-gray-600" id="my-bookings-desc">عرض حجوزاتك الخاصة</p>
        <div class="mt-4 text-xs text-gray-600 font-medium">
            <span id="quick-access-my">وصول سريع</span> →
        </div>
    </div>
</a>

            <!-- Add Payment -->
            <a href="{{ route('admin.payments.create') }}"
                class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
                <div class="text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-money-bill-wave text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2" id="add-payment-title">إضافة دفعة</h3>
                    <p class="text-sm text-gray-600" id="add-payment-desc">تسجيل دفعة مالية من مستأجر</p>
                    <div class="mt-4 text-xs text-emerald-600 font-medium">
                        <span id="quick-access-3">وصول سريع</span> →
                    </div>
                </div>
            </a>

            <!-- Add Expense -->
            <a href="{{ route('admin.expenses.create') }}"
                class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
                <div class="text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-rose-200 transition-colors">
                        <i class="fas fa-receipt text-rose-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2" id="add-expense-title">إضافة مصروف</h3>
                    <p class="text-sm text-gray-600" id="add-expense-desc">تسجيل مصروف جديد للمبنى</p>
                    <div class="mt-4 text-xs text-rose-600 font-medium">
                        <span id="quick-access-4">وصول سريع</span> →
                    </div>
                </div>
            </a>

            <!-- Cleaning Dashboard -->

            <a href="{{ route('admin.cleaning.dashboard') }}"
                class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
                <div class="text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                        <i class="fas fa-broom text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">داشبورد النظافة</h3>
                    <p class="text-sm text-gray-600">متابعة وتنفيذ مهام تنظيف الغرف تحت الصيانة</p>
                    <div class="mt-4 text-xs text-green-600 font-medium">
                        <span>وصول سريع</span> →
                    </div>
                </div>
            </a>



            <!-- Tenant Management -->
            <a href="#tenants"
                class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
                <div class="text-center">
                    <div
                        class="mx-auto w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                        <i class="fas fa-users text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2" id="tenants-title">إدارة المستأجرين</h3>
                    <p class="text-sm text-gray-600" id="tenants-desc">عرض وإدارة بيانات المستأجرين</p>
                    <div class="mt-4 text-xs text-purple-600 font-medium">
                        <span id="quick-access-6">وصول سريع</span> →
                    </div>
                </div>
            </a>

            <!-- Maintenance -->
<a href="{{ route('admin.technician.maintenance') }}"
    class="card-hover bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 group">
    <div class="text-center">
        <div
            class="mx-auto w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-orange-200 transition-colors">
            <i class="fas fa-tools text-orange-600 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">
            {{ __('messages.maintenance_card_title') }}
        </h3>
        <p class="text-sm text-gray-600">
            {{ __('messages.maintenance_card_desc') }}
        </p>
        <div class="mt-4 text-xs text-orange-600 font-medium">
            <span>{{ __('messages.quick_access') }}</span> →
        </div>
    </div>
</a>
 
        </div>

        <!-- Quick Actions Bar for Mobile -->
        <div class="fixed bottom-4 left-4 right-4 lg:hidden">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-4">
                <div class="flex justify-around items-center">
                    <button class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-home text-green-600"></i>
                    </button>
                    <button class="p-3 bg-teal-100 rounded-xl">
                        <i class="fas fa-plus text-teal-600"></i>
                    </button>
                    <button class="p-3 bg-emerald-100 rounded-xl">
                        <i class="fas fa-money-bill-wave text-emerald-600"></i>
                    </button>
                    <button class="p-3 bg-blue-100 rounded-xl">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let currentLang = 'ar';

        const translations = {
            ar: {
                'main-title': 'لوحة الاختصارات السريعة',
                'main-subtitle': 'الوصول السريع للمهام الأساسية في النظام',
                'lang-button': 'EN',
                'available-units': 'الوحدات المتاحة',
                'active-bookings': 'الحجوزات النشطة',
                'monthly-revenue': 'الإيرادات الشهرية',
                'available-rooms-title': 'الغرف المتاحة',
                'available-rooms-desc': 'عرض الوحدات الجاهزة للإيجار',
                'book-room-title': 'حجز غرفة',
                'book-room-desc': 'إضافة حجز جديد لوحدة متاحة',
                'add-payment-title': 'إضافة دفعة',
                'add-payment-desc': 'تسجيل دفعة مالية من مستأجر',
                'add-expense-title': 'إضافة مصروف',
                'add-expense-desc': 'تسجيل مصروف جديد للمبنى',
                'reports-title': 'التقارير المالية',
                'reports-desc': 'عرض تقارير مفصلة للإيرادات والمصروفات',
                'tenants-title': 'إدارة المستأجرين',
                'tenants-desc': 'عرض وإدارة بيانات المستأجرين',
                'maintenance-title': 'طلبات الصيانة',
                'maintenance-desc': 'إدارة ومتابعة طلبات الصيانة',
                'settings-title': 'الإعدادات',
                'settings-desc': 'إعدادات النظام والتخصيص',
                'quick-access': 'وصول سريع',
                'quick-access-2': 'وصول سريع',
                'quick-access-3': 'وصول سريع',
                'quick-access-4': 'وصول سريع',
                'quick-access-5': 'وصول سريع',
                'quick-access-6': 'وصول سريع',
                'quick-access-7': 'وصول سريع',
                'quick-access-8': 'وصول سريع'
            },
            en: {
                'main-title': 'Quick Shortcuts Dashboard',
                'main-subtitle': 'Fast access to essential system tasks',
                'lang-button': 'عر',
                'available-units': 'Available Units',
                'active-bookings': 'Active Bookings',
                'monthly-revenue': 'Monthly Revenue',
                'available-rooms-title': 'Available Rooms',
                'available-rooms-desc': 'View units ready for rent',
                'book-room-title': 'Book Room',
                'book-room-desc': 'Add new booking for available unit',
                'add-payment-title': 'Add Payment',
                'add-payment-desc': 'Record financial payment from tenant',
                'add-expense-title': 'Add Expense',
                'add-expense-desc': 'Record new building expense',
                'reports-title': 'Financial Reports',
                'reports-desc': 'View detailed revenue and expense reports',
                'tenants-title': 'Tenant Management',
                'tenants-desc': 'View and manage tenant information',
                'maintenance-title': 'Maintenance Requests',
                'maintenance-desc': 'Manage and track maintenance requests',
                'settings-title': 'Settings',
                'settings-desc': 'System settings and customization',
                'quick-access': 'Quick Access',
                'quick-access-2': 'Quick Access',
                'quick-access-3': 'Quick Access',
                'quick-access-4': 'Quick Access',
                'quick-access-5': 'Quick Access',
                'quick-access-6': 'Quick Access',
                'quick-access-7': 'Quick Access',
                'quick-access-8': 'Quick Access'
            }
        };

        function toggleLanguage() {
            currentLang = currentLang === 'ar' ? 'en' : 'ar';

            // Update document direction and language
            document.documentElement.lang = currentLang;
            document.documentElement.dir = currentLang === 'ar' ? 'rtl' : 'ltr';

            // Update all text elements
            Object.keys(translations[currentLang]).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = translations[currentLang][key];
                }
            });

            // Add smooth transition effect
            document.body.style.transition = 'all 0.3s ease';
        }

        // Add click handlers for shortcuts
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('href').substring(1);
                console.log(`تم النقر على: ${target}`);

                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.className = 'absolute inset-0 bg-white bg-opacity-20 rounded-2xl animate-pulse';
                this.style.position = 'relative';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 300);
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.querySelectorAll('a, button').forEach(el => {
                    el.addEventListener('focus', function() {
                        this.style.outline = '2px solid #667eea';
                        this.style.outlineOffset = '2px';
                    });

                    el.addEventListener('blur', function() {
                        this.style.outline = 'none';
                    });
                });
            }
        });
    </script>
</body>

</html>
