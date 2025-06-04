@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold mb-2">تفاصيل البلاغ</h1>
                        <div class="flex items-center gap-2">
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                                #{{ $request->id }}
                            </span>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $request->status ?? 'جديد' }}
                            </span>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <svg class="w-16 h-16 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Unit Information Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V15a1 1 0 001 1h3a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h3a1 1 0 001-1v-2.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                            </svg>
                            بيانات الوحدة
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="text-sm text-gray-600 mb-1">المبنى</div>
                                <div class="font-semibold text-gray-900">{{ $request->building->name ?? 'غير محدد' }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="text-sm text-gray-600 mb-1">رقم الوحدة</div>
                                <div class="font-semibold text-gray-900">{{ $request->unit->unit_number ?? 'غير محدد' }}</div>
                            </div>
                        </div>
                        
                        @php
                            $tenant = $request->unit->activeContract->tenant ?? null;
                        @endphp
                        
                        <div class="border-t pt-4 mt-4">
                            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                بيانات المستأجر
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-blue-50 rounded-xl p-4">
                                    <div class="text-sm text-blue-600 mb-1">الاسم</div>
                                    <div class="font-semibold text-blue-900">{{ $tenant?->name ?? '-' }}</div>
                                </div>
                                <div class="bg-blue-50 rounded-xl p-4">
                                    <div class="text-sm text-blue-600 mb-1">رقم الهاتف</div>
                                    <div class="font-semibold text-blue-900 direction-ltr"> {{ $tenant?->phone ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Issue Details Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                            تفاصيل العطل
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-orange-50 rounded-xl p-4">
                                <div class="text-sm text-orange-600 mb-1">نوع العطل</div>
                                <div class="font-semibold text-orange-900">{{ $request->subSpecialty->name ?? 'غير محدد' }}</div>
                            </div>
                            <div class="bg-orange-50 rounded-xl p-4">
                                <div class="text-sm text-orange-600 mb-1">التخصص الرئيسي</div>
                                <div class="font-semibold text-orange-900">{{ $request->subSpecialty->parent->name ?? 'غير محدد' }}</div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-sm text-gray-600 mb-2">وصف المشكلة</div>
                            <div class="text-gray-900 leading-relaxed">
                                {{ $request->description ?? 'لا يوجد وصف متاح' }}
                            </div>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-4">
                            <div class="text-sm text-green-600 mb-1">التكلفة المقدرة</div>
                            <div class="font-bold text-2xl text-green-700">
                                {{ $request->cost ?? '0' }} 
                                <span class="text-sm font-normal">درهم إماراتي</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                @if ($request->image || $request->completed_image)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                            الصور المرفقة
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @if ($request->image)
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                    صورة البلاغ الأولية
                                </h3>
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $request->image) }}" 
                                         alt="صورة البلاغ" 
                                         class="w-full h-48 sm:h-56 object-cover rounded-xl border-2 border-gray-200 group-hover:border-purple-300 transition-colors cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-colors flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if ($request->completed_image)
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                    صورة بعد الإنجاز
                                </h3>
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $request->completed_image) }}" 
                                         alt="صورة بعد الإنجاز" 
                                         class="w-full h-48 sm:h-56 object-cover rounded-xl border-2 border-gray-200 group-hover:border-purple-300 transition-colors cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-xl transition-colors flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                
                <!-- Technician Info Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            معلومات الفني
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                {{ $request->technician->name ?? 'لم يتم التعيين بعد' }}
                            </h3>
                            <div class="text-sm text-gray-600 mb-3">
                                الفني المسؤول
                            </div>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-xl p-3 text-center">
                            <div class="text-xs text-indigo-600 mb-1">طريقة التعيين</div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $request->assigned_manually ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $request->assigned_manually ? 'يدوي' : 'تلقائي' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            التسلسل الزمني
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Created -->
                            @if($request->created_at)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm">تم إنشاء البلاغ</div>
                                    <div class="text-xs text-gray-600 mt-1">{{ $request->created_at->format('Y/m/d H:i') }}</div>
                                    <div class="text-xs text-gray-500">بواسطة: {{ $request->creator->name ?? 'غير محدد' }}</div>
                                </div>
                            </div>
                            @endif

                            <!-- In Progress -->
                            @if($request->in_progress_at)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm">بدء التنفيذ</div>
                                    <div class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($request->in_progress_at)->format('Y/m/d H:i') }}</div>
                                    <div class="text-xs text-gray-500">بواسطة: {{ $request->inProgressBy->name ?? 'غير محدد' }}</div>
                                </div>
                            </div>
                            @endif

                            <!-- Completed -->
                            @if($request->completed_at)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm">تم الإنجاز</div>
                                    <div class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($request->completed_at)->format('Y/m/d H:i') }}</div>
                                    <div class="text-xs text-gray-500">بواسطة: {{ $request->completedBy->name ?? 'غير محدد' }}</div>
                                </div>
                            </div>
                            @endif

                            <!-- Rejected -->
                            @if($request->rejected_at)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-sm">تم الرفض</div>
                                    <div class="text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($request->rejected_at)->format('Y/m/d H:i') }}</div>
                                    <div class="text-xs text-gray-500">بواسطة: {{ $request->rejectedBy->name ?? 'غير محدد' }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<style>
@media (max-width: 640px) {
    .direction-ltr {
        direction: ltr;
        text-align: left;
    }
}

/* Smooth transitions */
* {
    transition: all 0.2s ease-in-out;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .max-w-4xl {
        padding: 0 1rem;
    }
    
    .grid {
        grid-template-columns: 1fr;
    }
    
    .text-2xl {
        font-size: 1.5rem;
    }
    
    .text-3xl {
        font-size: 1.75rem;
    }
}

/* Landscape mobile optimization */
@media (max-height: 500px) and (orientation: landscape) {
    .py-8 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    
    .py-4 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    
    .space-y-6 > * + * {
        margin-top: 1rem;
    }
}
</style>

<script>
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection