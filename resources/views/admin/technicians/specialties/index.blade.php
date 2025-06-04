@extends('layouts.app')

@section('title')
    {{ app()->getLocale() === 'ar' ? 'إدارة التخصصات' : 'Manage Specialties' }}
@endsection

@push('styles')
<style>
    body {
        font-family: 'Inter', sans-serif; /* خط حديث */
        background-color: #f4f7f6; /* خلفية أفتح وأكثر حداثة */
    }

    .container-modern {
        max-width: 1000px; /* زيادة العرض قليلاً */
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px; /* حواف مدورة أكثر */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* ظل واضح وأنيق */
    }

    .header-modern {
        display: flex;
        justify-content: space-between;
        align-items: flex-end; /* محاذاة العناصر للأسفل */
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-modern h1 {
        font-size: 2.5rem; /* خط أكبر للعنوان */
        font-weight: 700; /* أثقل للعنوان */
        color: #212529; /* لون داكن أكثر احترافية */
        margin: 0;
    }

    .header-modern p {
        color: #6c757d; /* لون رمادي ناعم للوصف */
        margin-top: 8px;
        font-size: 1.05rem;
    }

    .search-input-modern {
        border: 1px solid #ced4da;
        padding: 10px 15px;
        border-radius: 8px;
        width: 100%;
        max-width: 350px; /* عرض ثابت لمدخل البحث */
        font-size: 1rem;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .search-input-modern:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.2); /* ظل أزرق عند التركيز */
    }

    .button-modern {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: background-color 0.2s ease, transform 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center; /* توسيط المحتوى داخل الزر */
        gap: 8px;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2); /* ظل للأزرار */
        width: 100%; /* اجعل الزر يأخذ كامل العرض */
        max-width: 350px; /* حدد نفس أقصى عرض لمدخل البحث */
    }

    .button-modern:hover {
        background-color: #0056b3;
        transform: translateY(-2px); /* تأثير رفع بسيط */
    }

    .specialty-card-modern {
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        margin-bottom: 25px;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* ظل أنيق للبطاقات */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .specialty-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .main-specialty-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .main-specialty-header h2 {
        font-size: 1.75rem; /* حجم عنوان التخصص الرئيسي */
        font-weight: 700;
        color: #343a40;
    }

    .action-icon-button {
        background: none;
        border: none;
        cursor: pointer;
        color: #6c757d;
        padding: 8px;
        border-radius: 6px;
        transition: color 0.2s ease, background-color 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .action-icon-button:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    .action-icon-button.delete:hover {
        color: #dc3545;
    }

    .sub-specialty-toggle {
        font-size: 0.95rem;
        font-weight: 600;
        color: #007bff;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 15px; /* مسافة بين العنوان الفرعي والزر */
        transition: color 0.2s ease;
    }

    .sub-specialty-toggle:hover {
        color: #0056b3;
    }

    .sub-specialties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* 200px الحد الأدنى للعرض */
        gap: 10px; /* مسافة أقل بين التخصصات الفرعية */
        padding-top: 15px; /* مسافة بين زر العرض والشبكة */
    }

    .sub-specialty-chip {
        background-color: #e9f0f9; /* لون خلفية خفيف للـ chip */
        color: #0056b3;
        padding: 8px 12px;
        border-radius: 20px; /* حواف دائرية للـ chip */
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .sub-specialty-chip:hover {
        background-color: #d6e4f7;
        transform: translateY(-1px);
    }

    .chip-actions {
        display: flex;
        gap: 4px; /* مسافة أقل بين أزرار الـ chip */
    }

    .chip-action-icon {
        color: #6c757d;
        cursor: pointer;
        transition: color 0.2s ease;
        font-size: 0.85rem; /* حجم أصغر للأيقونات داخل الـ chip */
    }

    .chip-action-icon:hover {
        color: #007bff;
    }

    .chip-action-icon.delete:hover {
        color: #dc3545;
    }

    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
        color: #888;
        border: 2px dashed #dee2e6; /* حدود متقطعة عصرية */
        border-radius: 10px;
        background-color: #fdfdfd;
        margin-top: 30px;
    }

    .empty-state-modern svg {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        color: #adb5bd;
    }

    .empty-state-modern h3 {
        font-size: 1.8rem;
        color: #495057;
        margin-bottom: 12px;
    }

    .empty-state-modern p {
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    /* Collapse animation */
    .collapse-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out; /* أبطأ ليكون مرئيا */
    }

    .collapse-content.show {
        max-height: 500px; /* قيمة كافية لاستيعاب المحتوى */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .header-modern {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-modern > div {
            width: 100%;
        }

        .header-modern .flex-col {
            width: 100%;
            align-items: stretch;
        }

        .search-input-modern,
        .button-modern { /* تطبيق التعديل هنا */
            max-width: 100%;
            width: 100%; /* ضمان أنها تأخذ كامل العرض */
        }

        .main-specialty-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .sub-specialties-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container-modern" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    {{-- Header Section --}}
    <div class="header-modern">
        <div>
            <h1>
                {{ app()->getLocale() === 'ar' ? 'إدارة التخصصات' : 'Manage Specialties' }}
            </h1>
            <p>
                {{ app()->getLocale() === 'ar'
                    ? 'إدارة وتنظيم تخصصات الفنيين والخدمات المتاحة.'
                    : 'Manage and organize technician specialties and available services.' }}
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center">
            {{-- Search Box --}}
            <input type="text"
                   id="searchBox"
                   class="search-input-modern"
                   placeholder="{{ app()->getLocale() === 'ar' ? 'البحث في التخصصات...' : 'Search specialties...' }}">

            {{-- Add New Button --}}
            <a href="{{ route('admin.technicians.specialties.create') }}" class="button-modern">
                <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ app()->getLocale() === 'ar' ? 'إضافة تخصص جديد' : 'Add New Specialty' }}
            </a>
        </div>
    </div>

    {{-- Specialties Content --}}
    <div id="specialtiesContainer">
        @forelse($specialties->where('is_main', true) as $main)
            <div class="specialty-card-modern">
                {{-- Main Specialty Header --}}
                <div class="main-specialty-header">
                    <div>
                        <h2 class="inline-flex items-center gap-2">
                             <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            {{ $main->name }}
                        </h2>
                        @if($main->description)
                            <p class="text-sm text-gray-500 mt-1">{{ $main->description }}</p>
                        @endif
                    </div>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.technicians.specialties.edit', $main->id) }}"
                           class="action-icon-button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>

                        <form action="{{ route('admin.technicians.specialties.destroy', $main->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد أنك تريد حذف هذا التخصص الرئيسي؟ سيتم حذف جميع التخصصات الفرعية المرتبطة به.' : 'Are you sure you want to delete this main specialty? All associated sub-specialties will also be deleted.' }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-icon-button delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Sub Specialties Section --}}
                @php
                    $subSpecialties = $specialties->where('parent_id', $main->id);
                @endphp

                @if ($subSpecialties->isNotEmpty())
                    <div class="mt-4">
                        <button type="button" class="sub-specialty-toggle"
                                onclick="toggleSubSpecialties(this, 'sub-content-{{ $main->id }}')">
                            <span class="text-gray-700">
                                {{ app()->getLocale() === 'ar' ? 'عرض المهام الإضافية' : 'View Sub Specialties' }}
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full mr-1 {{ app()->getLocale() === 'ar' ? 'mr-1' : '' }}">{{ $subSpecialties->count() }}</span>
                            </span>
                            <svg class="w-4 h-4 text-blue-600 transition-transform duration-300 transform {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="sub-content-{{ $main->id }}" class="collapse-content">
                            <div class="sub-specialties-grid">
                                @foreach ($subSpecialties as $sub)
                                    <div class="sub-specialty-chip">
                                        <span class="font-medium">{{ $sub->name }}</span>
                                        <div class="chip-actions">
                                            <a href="{{ route('admin.technicians.specialties.edit', $sub->id) }}"
                                               class="chip-action-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>

                                            <form action="{{ route('admin.technicians.specialties.destroy', $sub->id) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا التخصص الفرعي؟' : 'Are you sure you want to delete this sub specialty?' }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="chip-action-icon delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-4 p-4 bg-gray-50 rounded text-center text-gray-500 text-sm border border-dashed border-gray-200">
                        {{ app()->getLocale() === 'ar' ? 'لا توجد مهام إضافية لهذا التخصص.' : 'No sub-specialties for this main specialty.' }}
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state-modern">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
                <h3>
                    {{ app()->getLocale() === 'ar' ? 'لا توجد تخصصات' : 'No Specialties Found' }}
                </h3>
                <p class="mb-4">
                    {{ app()->getLocale() === 'ar'
                        ? 'لم يتم إضافة أي تخصصات بعد. ابدأ بإضافة التخصص الأول!'
                        : 'No specialties have been added yet. Start by adding your first specialty!' }}
                </p>
                <a href="{{ route('admin.technicians.specialties.create') }}" class="button-modern">
                    <svg class="w-5 h-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'إضافة أول تخصص' : 'Add First Specialty' }}
                </a>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchBox = document.getElementById('searchBox');
    const specialtiesContainer = document.getElementById('specialtiesContainer');
    let noResultsState = null; // To keep track of the no results state

    if (searchBox) {
        searchBox.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const specialtyCards = specialtiesContainer.querySelectorAll('.specialty-card-modern');
            let hasVisibleResults = false;

            specialtyCards.forEach(card => {
                const mainSpecialtyName = card.querySelector('h2').textContent.toLowerCase();
                const subSpecialtyChips = card.querySelectorAll('.sub-specialty-chip span.font-medium');
                
                let isMainVisible = mainSpecialtyName.includes(searchTerm);
                let isSubVisible = false;

                // Check sub-specialties if main is not visible
                if (!isMainVisible) {
                    subSpecialtyChips.forEach(chipName => {
                        if (chipName.textContent.toLowerCase().includes(searchTerm)) {
                            isSubVisible = true;
                        }
                    });
                }
                
                if (isMainVisible || isSubVisible) {
                    card.style.display = 'block';
                    hasVisibleResults = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Handle no search results state
            if (!hasVisibleResults && searchTerm.length > 0) {
                if (!noResultsState) {
                    noResultsState = document.createElement('div');
                    noResultsState.className = 'empty-state-modern';
                    noResultsState.id = 'noSearchResultsState';
                    noResultsState.innerHTML = `
                        <svg class="mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3>
                            ${document.dir === 'rtl' ? 'لا توجد نتائج بحث' : 'No Search Results'}
                        </h3>
                        <p>
                            ${document.dir === 'rtl' ? `لم يتم العثور على تخصصات تطابق "${searchTerm}".` : `No specialties found matching "${searchTerm}".`}
                        </p>
                    `;
                    specialtiesContainer.appendChild(noResultsState);
                }
            } else {
                if (noResultsState) {
                    noResultsState.remove();
                    noResultsState = null;
                }
            }
        });
    }
    
    // Function to toggle sub-specialties visibility
    window.toggleSubSpecialties = function(button, contentId) {
        const content = document.getElementById(contentId);
        const icon = button.querySelector('svg');
        const textSpan = button.querySelector('span'); // Get the span containing the text

        if (content.classList.contains('show')) {
            content.classList.remove('show');
            icon.classList.remove('rotate-0'); // Reset rotation
            if (document.dir === 'rtl') {
                 icon.classList.add('rotate-180');
            }
            textSpan.innerHTML = `
                ${document.dir === 'rtl' ? 'عرض المهام الإضافية' : 'View Sub Specialties'}
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full {{ app()->getLocale() === 'ar' ? 'mr-1' : '' }}">${content.querySelectorAll('.sub-specialty-chip').length}</span>
            `;
        } else {
            content.classList.add('show');
            icon.classList.add('rotate-0'); // Rotate to show expanded state
            if (document.dir === 'rtl') {
                icon.classList.remove('rotate-180');
            }
            textSpan.innerHTML = `
                ${document.dir === 'rtl' ? 'إخفاء المهام الإضافية' : 'Hide Sub Specialties'}
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full {{ app()->getLocale() === 'ar' ? 'mr-1' : '' }}">${content.querySelectorAll('.sub-specialty-chip').length}</span>
            `;
        }
    };

    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                // Store original content and disable
                submitBtn.dataset.originalHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';

                // Check if it's an icon button or a larger button
                if (submitBtn.classList.contains('action-icon-button') || submitBtn.classList.contains('chip-action-icon')) {
                    submitBtn.innerHTML = `
                        <svg class="animate-spin w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    `;
                } else {
                    submitBtn.innerHTML = `
                        <svg class="animate-spin w-4 h-4 inline-block {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        ${document.dir === 'rtl' ? 'جاري التنفيذ...' : 'Processing...'}
                    `;
                }
            }
        });
    });
});
</script>
@endpush
@endsection