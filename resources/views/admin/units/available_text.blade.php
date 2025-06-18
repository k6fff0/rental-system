@extends('layouts.app')

@section('content')
    <style>
        /* تحسينات عامة للصفحة */
        body {
            font-family: 'Tajawal', 'Segoe UI', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* تحسينات للهاتف */
        @media (max-width: 640px) {
            .responsive-padding {
                padding: 15px;
            }
            
            .responsive-text {
                font-size: 0.9rem;
            }
            
            .responsive-heading {
                font-size: 1.4rem;
            }
        }
        
        /* تحسينات منطقة النص */
        .content-box {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            background-color: #f9fafb;
            direction: rtl;
            line-height: 1.7;
        }
        
        /* تحسينات الزر */
        .copy-btn {
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.3);
        }
        
        .copy-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.4);
        }
        
        /* تحسينات التكست اريا */
        .custom-textarea {
            resize: none;
            border: none;
            background-color: transparent;
            font-family: 'Courier New', Courier, monospace;
            line-height: 1.8;
            padding: 15px;
        }
        
        /* تحسينات للتاريخ */
        .date-text {
            color: #6b7280;
            font-size: 0.85rem;
        }
    </style>

    <div class="min-h-screen bg-white responsive-padding">
        <div class="max-w-4xl mx-auto">
            <!-- الهيدر -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
                <h2 class="text-2xl font-bold text-gray-800 responsive-heading">
                    <span class="mr-2">📋</span> النسخة الكتابية للغرف المتاحة
                </h2>
                
                <button onclick="copyToClipboard()"
                    class="copy-btn bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
                    <span>📋</span>
                    <span>نسخ كل النص</span>
                </button>
            </div>

            <!-- التاريخ -->
            <p class="date-text mb-5">
                تم التحديث بتاريخ: {{ now()->format('Y-m-d H:i') }}
            </p>

            <!-- محتوى الغرف -->
            <div class="content-box h-[calc(100vh-180px)] overflow-auto responsive-text">
                <textarea id="textContent" 
                    class="custom-textarea w-full h-full focus:outline-none"
                    readonly>
@foreach ($units as $buildingName => $buildingUnits)
🏠 {{ $buildingName }}
@php
    $building = $buildingUnits->first()->building;
@endphp
@foreach ($building->supervisors as $supervisor)
👤 مسئول الفيلا: {{ $supervisor->name }} 
📞 {{ $supervisor->phone }}
@endforeach

@foreach ($buildingUnits as $unit)
🛏 غرفة رقم: {{ $unit->unit_number }}
🏷️ النوع: {{ __('messages.' . $unit->unit_type) }}
💵 الإيجار: {{ $unit->rent_price }} درهم
-----------------------------
@endforeach

@endforeach
                </textarea>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const textarea = document.getElementById("textContent");
            textarea.select();
            textarea.setSelectionRange(0, 99999);
            
            try {
                document.execCommand("copy");
                
                // تغيير نص الزر مؤقتًا للإشارة إلى النجاح
                const btn = document.querySelector('.copy-btn');
                btn.innerHTML = '<span>✅</span><span>تم النسخ!</span>';
                
                setTimeout(() => {
                    btn.innerHTML = '<span>📋</span><span>نسخ كل النص</span>';
                }, 2000);
                
            } catch (err) {
                alert("حدث خطأ أثناء النسخ، يرجى المحاولة مرة أخرى");
            }
        }
        
        // جعل التكست اريا تأخذ المساحة المتبقية تلقائيًا
        function adjustTextareaHeight() {
            const headerHeight = document.querySelector('h2').offsetHeight;
            const dateHeight = document.querySelector('.date-text').offsetHeight;
            const remainingHeight = window.innerHeight - headerHeight - dateHeight - 100;
            document.querySelector('.content-box').style.height = `${remainingHeight}px`;
        }
        
        // تعديل الارتفاع عند تغيير حجم النافذة
        window.addEventListener('resize', adjustTextareaHeight);
        
        // تعديل الارتفاع عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', adjustTextareaHeight);
    </script>
@endsection