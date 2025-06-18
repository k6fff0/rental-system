<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="شركة سمارت ستيب - حلول عقارية متكاملة في مدينة العين، نقدم خدمات إدارة العقارات، التأجير، الصيانة والمقاولات">
    <meta name="keywords" content="عقارات العين, إدارة عقارات, تأجير عقارات, صيانة عقارات, مقاولات العين">
    <title>سمارت ستيب | حلول عقارية متكاملة في العين</title>
    
    <!-- تحسين أداء تحميل الخطوط -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- تحميل Tailwind CSS بشكل غير متزامن -->
    <script src="https://cdn.tailwindcss.com" async></script>
    
    <!-- أنماط مخصصة مع تحسينات الأداء -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #06b6d4;
            --accent-color: #10b981;
            --dark-bg: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.1);
        }
        
        * {
            font-family: 'Tajawal', 'Inter', sans-serif;
            box-sizing: border-box;
        }
        
        body {
            scroll-behavior: smooth;
            text-rendering: optimizeLegibility;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .ltr-dir {
            direction: ltr;
        }
        
        /* Glass morphism effects */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .glass-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Animated gradients */
        .gradient-animated {
            background: linear-gradient(-45deg, #4f46e5, #06b6d4, #10b981, #8b5cf6);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* تحسينات الأداء للصور */
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        
        .lazy {
            opacity: 0;
            transition: opacity 0.6s ease;
        }
        
        .lazy.loaded {
            opacity: 1;
        }
        
        /* تأثيرات الحركة المحسنة */
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(40px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        @keyframes fadeInLeft {
            from { 
                opacity: 0; 
                transform: translateX(-40px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }
        
        @keyframes fadeInRight {
            from { 
                opacity: 0; 
                transform: translateX(40px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-fadeInLeft {
            animation: fadeInLeft 0.8s ease-out forwards;
        }
        
        .animate-fadeInRight {
            animation: fadeInRight 0.8s ease-out forwards;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-pulse-gentle {
            animation: pulse 4s ease-in-out infinite;
        }
        
        /* تحسينات للشريط العلوي */
        .navbar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
        }
        
        /* أزرار محسنة مع تأثيرات حديثة */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.4s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        /* بطاقات العقارات المحسنة */
        .property-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .property-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 1);
        }
        
        .property-card .property-image {
            overflow: hidden;
            position: relative;
        }
        
        .property-card .property-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(79, 70, 229, 0.8), rgba(6, 182, 212, 0.8));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }
        
        .property-card:hover .property-image::before {
            opacity: 1;
        }
        
        .property-card .property-image img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .property-card:hover .property-image img {
            transform: scale(1.1);
        }
        
        /* خدمات محسنة */
        .service-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .service-card:hover::before {
            transform: scaleX(1);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 1);
        }
        
        .service-icon {
            transition: all 0.4s ease;
        }
        
        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        /* قسم الاتصال المحسن */
        .contact-form input,
        .contact-form textarea,
        .contact-form select {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-form input:focus,
        .contact-form textarea:focus,
        .contact-form select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: rgba(255, 255, 255, 1);
            transform: scale(1.02);
        }
        
        /* تأثيرات التحميل المحسنة */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        
        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 20px;
        }
        
        .loader-text {
            color: white;
            font-size: 18px;
            font-weight: 600;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.5s forwards;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Parallax effects */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        /* Hero section enhancements */
        .hero-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }
        
        /* Scroll reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Counter animations */
        .counter-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
        }
        
        .counter-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        /* Footer enhancements */
        .footer-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .property-card:hover {
                transform: translateY(-5px) scale(1.01);
            }
            
            .service-card:hover {
                transform: translateY(-5px);
            }
        }
        
        /* Smooth scrolling for mobile */
        @media (prefers-reduced-motion: no-preference) {
            html {
                scroll-behavior: smooth;
            }
        }
        
        /* Performance optimizations */
        .will-change-transform {
            will-change: transform;
        }
        
        .gpu-accelerated {
            transform: translateZ(0);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- شاشة التحميل المحسنة -->
    <div class="loader" id="pageLoader">
        <div class="spinner"></div>
        <div class="loader-text">مرحباً بك في سمارت ستيب</div>
    </div>

    <!-- شريط التنقل المحسن -->
    <nav class="navbar glass-navbar fixed top-0 w-full z-50 py-4" id="mainNavbar">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center">
               <!-- الشعار المحسن -->
<div class="flex items-center space-x-3 space-x-reverse">
    <!-- ✅ اللوجو صورة بدل SVG مع تأثيرات -->
    <div class="relative">
        <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Smart Step Logo" class="w-16 h-16 rounded-xl object-cover shadow-lg animate-pulse-gentle">
        <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-transparent to-white/20"></div>
    </div>

    <!-- اسم الشركة مع تأثير متدرج -->
    <a href="#" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent">{{ __('messages.company_name') }}</a>
</div>


                <!-- قائمة التنقل للأجهزة الكبيرة -->
                <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                    <a href="{{ route('units.available') }}" class="text-gray-700 hover:text-indigo-600 transition-all duration-300 font-medium relative group">
                        {{ __('messages.available_rooms') }}
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-cyan-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#about" class="text-gray-700 hover:text-indigo-600 transition-all duration-300 font-medium relative group">
                        {{ __('messages.nav_about') }}
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-cyan-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#services" class="text-gray-700 hover:text-indigo-600 transition-all duration-300 font-medium relative group">
                        {{ __('messages.nav_services') }}
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-cyan-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#contact" class="text-gray-700 hover:text-indigo-600 transition-all duration-300 font-medium relative group">
                        {{ __('messages.nav_contact') }}
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-cyan-500 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>

              <!-- الأزرار المحسنة -->
<div class="flex items-center space-x-4 space-x-reverse">
    <!-- تغيير اللغة -->
    <select onchange="window.location.href = '/lang/' + this.value + '?redirect={{ urlencode(request()->fullUrl()) }}'"
            class="contact-form px-4 py-2 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-medium">
        <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>العربية</option>
        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
        <option value="ur" {{ app()->getLocale() === 'ur' ? 'selected' : '' }}>اردو</option>
    </select>

    <!-- زر تسجيل الدخول -->
    <a href="{{ route('login') }}" class="btn-primary text-white px-6 py-2.5 rounded-lg text-sm font-medium">
        {{ __('messages.login') }}
    </a>
</div>

                <!-- زر القائمة للأجهزة الصغيرة -->
                <button class="md:hidden text-gray-700 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors" id="mobileMenuButton">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- قائمة التنقل للأجهزة الصغيرة -->
        <div class="md:hidden hidden glass-card w-full py-4 px-4 mx-4 mt-4 rounded-xl" id="mobileMenu">
            <div class="flex flex-col space-y-3">
                <a href="#home" class="text-gray-700 hover:text-indigo-600 transition-colors py-3 px-4 rounded-lg hover:bg-white/50">{{ __('messages.nav_home') }}</a>
                <a href="#about" class="text-gray-700 hover:text-indigo-600 transition-colors py-3 px-4 rounded-lg hover:bg-white/50">{{ __('messages.nav_about') }}</a>
                <a href="#services" class="text-gray-700 hover:text-indigo-600 transition-colors py-3 px-4 rounded-lg hover:bg-white/50">{{ __('messages.nav_services') }}</a>
                <a href="#properties" class="text-gray-700 hover:text-indigo-600 transition-colors py-3 px-4 rounded-lg hover:bg-white/50">{{ __('messages.nav_properties') }}</a>
                <a href="#contact" class="text-gray-700 hover:text-indigo-600 transition-colors py-3 px-4 rounded-lg hover:bg-white/50">{{ __('messages.nav_contact') }}</a>
            </div>
        </div>
    </nav>

    <!-- قسم الهيرو المحسن -->
    <section id="home" class="relative h-screen flex items-center justify-center overflow-hidden gradient-animated hero-pattern">
    <!-- خلفية متدرجة مع تأثيرات -->
    <div class="absolute inset-0 bg-gradient-to-br from-black/40 via-black/30 to-black/50 z-10"></div>
    
    <!-- عناصر تزيينية متحركة -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float" style="animation-delay: 0s;"></div>
    <div class="absolute top-40 right-20 w-16 h-16 bg-white/5 rounded-full animate-float" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-40 left-20 w-24 h-24 bg-white/5 rounded-full animate-float" style="animation-delay: 4s;"></div>

    <!-- خلفية متغيرة -->
    <div id="slider" class="absolute inset-0 w-full h-full z-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
             alt="عقارات فاخرة"
             class="slider-img absolute inset-0 w-full h-full object-cover transition-all duration-2000 opacity-100" />
        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
             alt="عقارات فاخرة"
             class="slider-img absolute inset-0 w-full h-full object-cover transition-all duration-2000 opacity-0" />
        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
             alt="عقارات فاخرة"
             class="slider-img absolute inset-0 w-full h-full object-cover transition-all duration-2000 opacity-0" />
    </div>

    <div class="container mx-auto px-4 z-20 text-center text-white">
        <div class="glass-card p-8 rounded-2xl max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 animate-fadeInUp bg-gradient-to-r from-white to-cyan-200 bg-clip-text text-transparent" style="animation-delay: 0.2s;">
                {{ __('messages.hero_title') }}
            </h1>
            <p class="text-xl md:text-2xl lg:text-3xl mb-8 max-w-3xl mx-auto animate-fadeInUp text-gray-100" style="animation-delay: 0.4s;">
                {{ __('messages.hero_subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-fadeInUp" style="animation-delay: 0.6s;">
                <a href="#services" class="btn-primary px-10 py-4 rounded-xl text-lg font-medium will-change-transform">
                    {{ __('messages.explore_services') }}
                </a>
                <a href="#contact" class="btn-secondary px-10 py-4 rounded-xl text-lg font-medium will-change-transform">
                    {{ __('messages.book_consultation') }}
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slides = document.querySelectorAll('.slider-img');
        let current = 0;

        setInterval(() => {
            slides[current].style.opacity = '0';
            slides[current].style.transform = 'scale(1.1)';

            current = (current + 1) % slides.length;

            slides[current].style.opacity = '1';
            slides[current].style.transform = 'scale(1)';
        }, 6000); // كل 6 ثواني يتغير مع انتقال أطول
    });
</script>


    <!-- قسم من نحن المحسن -->
    <section id="about" class="py-20 bg-gradient-to-br from-white to-gray-50 reveal">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 animate-fadeInLeft">
                    <div class="inline-block px-4 py-2 bg-gradient-to-r from-indigo-100 to-cyan-100 rounded-full text-indigo-600 font-semibold text-sm mb-6">
                        من نحن
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8 leading-tight">{{ __('messages.about_title') }}</h2>
                    <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                       {{ __('messages.about_description') }}
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                        <div class="counter-card p-6 rounded-2xl text-center group">
                            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent mb-3" id="propertiesCounter">0</div>
                            <p class="text-gray-600 font-medium">{{ __('messages.about_properties') }}</p>
                        </div>
                        <div class="counter-card p-6 rounded-2xl text-center group">
                            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent mb-3" id="yearsCounter">0</div>
                            <p class="text-gray-600 font-medium">{{ __('messages.about_experience') }}</p>
                        </div>
                        <div class="counter-card p-6 rounded-2xl text-center group">
                            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent mb-3" id="clientsCounter">0</div>
                            <p class="text-gray-600 font-medium">{{ __('messages.about_clients') }}</p>
                        </div>
                    </div>
                    
                    <a href="#contact" class="btn-primary inline-block mt-10 px-8 py-4 rounded-xl font-medium">{{ __('messages.contact_us') }}</a>
                </div>
                
                <div class="order-1 lg:order-2 animate-fadeInRight">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1560520031-3a4dc4e9de0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1067&q=80" 
                             alt="{{ __('messages.smart_step_team') }}" 
                             class="w-full h-auto lazy" 
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <div class="glass-card p-6 rounded-2xl">
                                <h3 class="text-2xl font-bold mb-2">{{ __('messages.our_team') }}</h3>
                                <p class="text-gray-200">{{ __('messages.real_estate_experts') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الخدمات المحسن -->
    <section id="services" class="py-20 bg-gradient-to-br from-gray-50 to-white reveal">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-indigo-100 to-cyan-100 rounded-full text-indigo-600 font-semibold text-sm mb-6">
                    خدماتنا
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">{{ __('messages.services_title') }}</h2>
                <p class="text-gray-600 max-w-3xl mx-auto text-lg">{{ __('messages.services_description') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- خدمة 1 -->
                <div class="service-card rounded-2xl p-8 text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center mb-6 mx-auto service-icon">
                        <svg class="w-10 h-10 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.service_rent') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('messages.service_rent_desc') }}</p>
                </div>

                <!-- خدمة 2 -->
                <div class="service-card rounded-2xl p-8 text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center mb-6 mx-auto service-icon">
                        <svg class="w-10 h-10 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.service_manage') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('messages.service_manage_desc') }}</p>
                </div>

                <!-- خدمة 3 -->
                <div class="service-card rounded-2xl p-8 text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-violet-100 rounded-2xl flex items-center justify-center mb-6 mx-auto service-icon">
                       <svg class="w-10 h-10 text-violet-600" width="40" height="40" viewBox="0 0 512 512" fill="currentColor">
                            <path d="M128,7.10542736e-15 C198.692448,7.10542736e-15 256,57.307552 256,128 C256,140.931179 254.082471,153.414494 250.516246,165.181113 L384,298.666667 C407.564149,322.230816 407.564149,360.435851 384,384 C360.435851,407.564149 322.230816,407.564149 298.666667,384 L165.181113,250.516246 C153.414494,254.082471 140.931179,256 128,256 C57.307552,256 7.10542736e-15,198.692448 7.10542736e-15,128 C7.10542736e-15,114.357909 2.13416363,101.214278 6.08683609,88.884763 L66.6347809,149.333333 L126.649,129.346 L129.329,126.666 L149.333333,66.7080586 L88.7145729,6.14152881 C101.0933,2.15385405 114.29512,7.10542736e-15 128,7.10542736e-15 Z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.service_maintenance') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('messages.service_maintenance_desc') }}</p>
                </div>

                <!-- خدمة 4 -->
                <div class="service-card rounded-2xl p-8 text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl flex items-center justify-center mb-6 mx-auto service-icon">
                        <svg class="w-10 h-10 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('messages.service_construction') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('messages.service_construction_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

 <!-- قسم الغرف المتاحة المحسن -->
<section id="properties" class="py-20 bg-gradient-to-br from-white to-gray-50 reveal">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-gradient-to-r from-indigo-100 to-cyan-100 rounded-full text-indigo-600 font-semibold text-sm mb-6">
                العقارات المتاحة
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">{{ __('messages.rooms_title') }}</h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">{{ __('messages.rooms_description') }}</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- غرفة 1 -->
            <div class="property-card rounded-3xl overflow-hidden shadow-lg will-change-transform">
                <div class="property-image relative h-64 md:h-72">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" 
                         alt="{{ __('messages.room_1_title') }}" 
                         class="w-full h-full object-cover lazy" 
                         loading="lazy">
                    <div class="absolute top-4 right-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        {{ __('messages.for_rent') }}
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('messages.room_1_title') }}</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ __('messages.room_1_desc') }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent">{{ __('messages.room_1_price') }}</span>
                        <a href="{{ route('units.available') }}" class="btn-primary px-6 py-3 rounded-xl text-sm font-medium">{{ __('messages.more_details') }}</a>
                    </div>
                </div>
            </div>

            <!-- غرفة 2 -->
            <div class="property-card rounded-3xl overflow-hidden shadow-lg will-change-transform">
                <div class="property-image relative h-64 md:h-72">
                    <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=1035&q=80" 
                         alt="{{ __('messages.room_2_title') }}" 
                         class="w-full h-full object-cover lazy" 
                         loading="lazy">
                    <div class="absolute top-4 right-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        {{ __('messages.new') }}
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('messages.room_2_title') }}</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ __('messages.room_2_desc') }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent">{{ __('messages.room_2_price') }}</span>
                        <a href="{{ route('units.available') }}" class="btn-primary px-6 py-3 rounded-xl text-sm font-medium">{{ __('messages.more_details') }}</a>
                    </div>
                </div>
            </div>

            <!-- غرفة 3 -->
            <div class="property-card rounded-3xl overflow-hidden shadow-lg will-change-transform">
                <div class="property-image relative h-64 md:h-72">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1169&q=80" 
                         alt="{{ __('messages.room_3_title') }}" 
                         class="w-full h-full object-cover lazy" 
                         loading="lazy">
                    <div class="absolute top-4 right-4 bg-gradient-to-r from-purple-500 to-violet-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        {{ __('messages.commercial') }}
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ __('messages.room_3_title') }}</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ __('messages.room_3_desc') }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-cyan-500 bg-clip-text text-transparent">{{ __('messages.room_3_price') }}</span>
                        <a href="{{ route('units.available') }}" class="btn-primary px-6 py-3 rounded-xl text-sm font-medium">{{ __('messages.more_details') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-16">
            <a href="{{ route('units.available') }}" class="btn-primary inline-block px-10 py-4 rounded-xl text-lg font-medium">{{ __('messages.view_all_units') }}</a>
        </div>
    </div>
</section>

    <!-- قسم الدعوة للعمل المحسن -->
    <section class="py-20 gradient-animated text-white reveal">
        <div class="container mx-auto px-4 text-center">
            <div class="glass-card p-12 rounded-3xl max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-8">{{ __('messages.cta_title') }}</h2>
                <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto text-gray-100">{{ __('messages.cta_description') }}</p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="#contact" class="bg-white text-indigo-600 hover:bg-gray-100 px-10 py-4 rounded-xl font-medium transition-all will-change-transform">{{ __('messages.contact_now') }}</a>
                    <!-- <a href="tel:+97137532593" class="btn-secondary px-10 py-4 rounded-xl font-medium will-change-transform">{{ __('messages.call_now') }}</a> -->
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الاتصال المحسن -->
    <section id="contact" class="py-20 bg-gradient-to-br from-gray-50 to-white reveal">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16">
                <!-- نموذج الاتصال -->
                <div class="animate-fadeInLeft">
                    <div class="inline-block px-4 py-2 bg-gradient-to-r from-indigo-100 to-cyan-100 rounded-full text-indigo-600 font-semibold text-sm mb-6">
                        تواصل معنا
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">{{ __('messages.contact_title') }}</h2>
                    <p class="text-gray-600 mb-10 text-lg">{{ __('messages.contact_subtitle') }}</p>
                    
                   <form action="{{ route('complaints.store') }}" method="POST" class="contact-form space-y-6">
                        @csrf

                        <div>
                            <label class="block text-gray-700 font-semibold mb-3 text-lg">{{ __('messages.full_name') }}</label>
                            <input type="text" name="name" required class="w-full px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('name') }}">
                            @error('name') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-3 text-lg">{{ __('messages.phone_number') }}</label>
                                <input type="text" name="phone" class="w-full px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('phone') }}">
                                @error('phone') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-3 text-lg">{{ __('messages.email') }}</label>
                                <input type="email" name="email" class="w-full px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('email') }}">
                                @error('email') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-3 text-lg">{{ __('messages.message') }}</label>
                            <textarea name="message" rows="6" required class="w-full px-6 py-4 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-primary w-full py-4 rounded-xl font-semibold text-lg">
                            {{ __('messages.send_message') }}
                        </button>
                    </form>

                </div>
                
                <!-- معلومات الاتصال -->
                <div class="animate-fadeInRight">
                    <div class="glass-card rounded-3xl p-10 shadow-xl h-full">
                        <h3 class="text-3xl font-bold text-gray-800 mb-10">{{ __('messages.contact_info_title') }}</h3>
                        
                        <div class="space-y-8">
                            <div class="flex items-start space-x-6 space-x-reverse">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('messages.address') }}</h4>
                                    <p class="text-gray-600 text-lg">عشارج ,مدينة العين، أبوظبي، الإمارات العربية المتحدة</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-6 space-x-reverse">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('messages.phone') }}</h4>
                                    <p class="text-gray-600 ltr-dir text-lg">+971 375 32 593</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-6 space-x-reverse">
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-violet-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('messages.email_title') }}</h4>
                                    <p class="text-gray-600 text-lg">info@smartstep-uae.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-6 space-x-reverse">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('messages.working_hours') }}</h4>
                                    <p class="text-gray-600 text-lg">السبت - الخميس: 9:00 ص - 8:00 م</p>
                                    <p class="text-gray-600 text-lg">الجمعة: مغلق</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- الفوتر المحسن -->
    <footer class="footer-gradient text-white pt-20 pb-10">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- معلومات الشركة -->
                <div>
                    <div class="flex items-center space-x-3 space-x-reverse mb-6">
                        <div class="w-12 h-12 gradient-animated rounded-2xl flex items-center justify-center">
                           <img src="{{ asset('storage/' . settings()->app_logo) }}" alt="Smart Step Logo" class="w-16 h-16 rounded-xl object-cover shadow-lg animate-pulse-gentle">
                        </div>
                        <h3 class="text-2xl font-bold">{{ __('messages.company_name') }}</h3>
                    </div>
                    <p class="text-gray-300 mb-6 text-lg leading-relaxed">شريكك الموثوق في العقارات والمقاولات في مدينة العين</p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="w-12 h-12 bg-white/10 hover:bg-white/20 rounded-2xl flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- روابط سريعة -->
                <div>
                    <h4 class="text-xl font-bold mb-6">{{ __('messages.quick_links') }}</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.nav_home') }}</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.nav_about') }}</a></li>
                        <li><a href="#services" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.nav_services') }}</a></li>
                        <li><a href="#properties" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.nav_properties') }}</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.nav_contact') }}</a></li>
                    </ul>
                </div>
                
                <!-- الخدمات -->
                <div>
                    <h4 class="text-xl font-bold mb-6">{{ __('messages.nav_services') }}</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.service_rent') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.service_manage') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.service_maintenance') }}</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 text-lg hover:translate-x-2 inline-block">{{ __('messages.service_construction') }}</a></li>
                    </ul>
                </div>
                
                <!-- النشرة البريدية -->
                <div>
                    <h4 class="text-xl font-bold mb-6">{{ __('messages.newsletter') }}</h4>
                    <p class="text-gray-300 mb-6 text-lg">{{ __('messages.subscribe_prompt') }}</p>
                    <form class="space-y-4">
                        <input type="email" placeholder="بريدك الإلكتروني" class="w-full px-6 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/20 transition-all backdrop-blur-10">
                        <button class="btn-primary w-full py-4 rounded-xl font-semibold">{{ __('messages.subscribe') }}</button>
                    </form>
                </div>
            </div>
            
            <!-- حقوق النشر -->
            <div class="border-t border-white/20 pt-8 text-center">
                <p class="text-gray-300 text-lg">&copy; {{ __('messages.rights_reserved') }}</p>
            </div>
        </div>
    </footer>

    <!-- الأكواد البرمجية المحسنة -->
    <script>
        // تحميل الصفحة مع تأثيرات
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loader = document.getElementById('pageLoader');
                loader.style.opacity = '0';
                loader.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    loader.style.display = 'none';
                    
                    // تحميل الصور المتأخرة
                    const lazyImages = document.querySelectorAll('.lazy');
                    lazyImages.forEach(img => {
                        img.classList.add('loaded');
                    });
                    
                    // تشغيل تأثيرات الإظهار
                    revealElements();
                }, 500);
            }, 1500);
        });

        // القائمة المتنقلة للأجهزة الصغيرة
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
            
            // تأثير الدوران للأيقونة
            this.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
        });

        // تأثير التمرير للشريط العلوي المحسن
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                navbar.classList.add('scrolled');
                
                // إخفاء/إظهار الشريط عند التمرير
                if (scrollTop > lastScrollTop && scrollTop > 200) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
            } else {
                navbar.classList.remove('scrolled');
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });

        // عداد الأرقام المحسن
        function animateCounters() {
            const counters = [
                { element: 'propertiesCounter', target: 150, duration: 2000, suffix: '+' },
                { element: 'yearsCounter', target: 10, duration: 1500, suffix: '+' },
                { element: 'clientsCounter', target: 2500, duration: 2500, suffix: '+' }
            ];
            
            counters.forEach(counter => {
                const element = document.getElementById(counter.element);
                const increment = counter.target / (counter.duration / 16);
                let current = 0;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < counter.target) {
                        element.textContent = Math.floor(current) + (counter.suffix || '');
                        requestAnimationFrame(updateCounter);
                    } else {
                        element.textContent = counter.target + (counter.suffix || '');
                    }
                };
                
                setTimeout(updateCounter, 500);
            });
        }

        // تأثيرات الإظهار عند التمرير
        function revealElements() {
            const reveals = document.querySelectorAll('.reveal');
            
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        
                        // تشغيل العداد إذا كان في قسم من نحن
                        if (entry.target.id === 'about') {
                            setTimeout(animateCounters, 300);
                        }
                    }
                });
            }, { 
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            reveals.forEach(reveal => {
                revealObserver.observe(reveal);
            });
        }

        // تأثيرات الماوس للبطاقات
        document.querySelectorAll('.property-card, .service-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.willChange = 'transform';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.willChange = 'auto';
            });
        });

        // تأثير الكتابة للعناوين
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            
            type();
        }

        // تحسين الأداء - تأخير التحميل للصور
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove('lazy');
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        // تطبيق مراقب الصور على جميع الصور
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });

        // تحسين التمرير الناعم
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            });
        });

        // تأثيرات الجسيمات للخلفية (اختياري)
        function createParticles() {
            const hero = document.getElementById('home');
            const particlesCount = 50;
            
            for (let i = 0; i < particlesCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.cssText = `
                    position: absolute;
                    width: 2px;
                    height: 2px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    top: ${Math.random() * 100}%;
                    left: ${Math.random() * 100}%;
                    animation: float ${3 + Math.random() * 4}s ease-in-out infinite;
                    animation-delay: ${Math.random() * 5}s;
                `;
                hero.appendChild(particle);
            }
        }

        // تشغيل تأثيرات إضافية بعد التحميل
        document.addEventListener('DOMContentLoaded', function() {
            // createParticles(); // تعليق هذا السطر إذا كنت لا تريد الجسيمات
            
            // تأثيرات إضافية للأزرار
            document.querySelectorAll('.btn-primary, .btn-secondary').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // تحسين الأداء - تقليل إعادة الرسم
        let ticking = false;
        function updateOnScroll() {
            // كود التمرير هنا
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateOnScroll);
                ticking = true;
            }
        });
    </script>
</body>