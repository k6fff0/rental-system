@extends('layouts.app')

@section('title')
    {{ app()->getLocale() === 'ar' ? 'إدارة التخصصات' : 'Manage Specialties' }}
@endsection

@push('styles')
    <style>
        /* Base styles with dark mode support */
        body {
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .container-modern {
            max-width: 1000px;
            margin: 20px auto;
            /* تصغير المسافة */
            padding: 20px;
            /* تصغير الpadding */
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        /* Dark mode container */
        @media (prefers-color-scheme: dark) {
            .container-modern {
                background-color: #1f2937;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            }
        }

        .dark .container-modern {
            background-color: #1f2937;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .header-modern {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 20px;
            /* تصغير المسافة */
            flex-wrap: wrap;
            gap: 15px;
            /* تصغير المسافة */
        }

        .header-modern h1 {
            font-size: 2rem;
            /* تصغير الخط */
            font-weight: 700;
            color: #212529;
            margin: 0;
            transition: color 0.3s ease;
        }

        /* Dark mode heading */
        @media (prefers-color-scheme: dark) {
            .header-modern h1 {
                color: #f9fafb;
            }
        }

        .dark .header-modern h1 {
            color: #f9fafb;
        }

        .header-modern p {
            color: #6c757d;
            margin-top: 5px;
            /* تصغير المسافة */
            font-size: 0.95rem;
            /* تصغير الخط */
            transition: color 0.3s ease;
        }

        /* Dark mode description */
        @media (prefers-color-scheme: dark) {
            .header-modern p {
                color: #9ca3af;
            }
        }

        .dark .header-modern p {
            color: #9ca3af;
        }

        .search-input-modern {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            /* تصغير الpadding */
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
            /* تصغير العرض */
            font-size: 0.9rem;
            /* تصغير الخط */
            box-sizing: border-box;
            transition: all 0.3s ease;
            background-color: #ffffff;
            color: #374151;
        }

        .search-input-modern:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Dark mode search input */
        @media (prefers-color-scheme: dark) {
            .search-input-modern {
                background-color: #374151;
                border-color: #4b5563;
                color: #f9fafb;
            }

            .search-input-modern::placeholder {
                color: #9ca3af;
            }
        }

        .dark .search-input-modern {
            background-color: #374151;
            border-color: #4b5563;
            color: #f9fafb;
        }

        .dark .search-input-modern::placeholder {
            color: #9ca3af;
        }

        .button-modern {
            background-color: #3b82f6;
            color: white;
            padding: 8px 16px;
            /* تصغير الpadding */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            /* تصغير الخط */
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            /* تصغير المسافة */
            box-shadow: 0 3px 8px rgba(59, 130, 246, 0.2);
            width: 100%;
            max-width: 300px;
            /* تصغير العرض */
        }

        .button-modern:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Dark mode button */
        .dark .button-modern {
            background-color: #3b82f6;
            box-shadow: 0 3px 8px rgba(59, 130, 246, 0.4);
        }

        .dark .button-modern:hover {
            background-color: #2563eb;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
        }

        .specialty-card-modern {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            margin-bottom: 15px;
            /* تصغير المسافة */
            padding: 18px;
            /* تصغير الpadding */
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .specialty-card-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 16px rgba(0, 0, 0, 0.08);
        }

        /* Dark mode card */
        @media (prefers-color-scheme: dark) {
            .specialty-card-modern {
                background-color: #374151;
                border-color: #4b5563;
                box-shadow: 0 3px 12px rgba(0, 0, 0, 0.2);
            }

            .specialty-card-modern:hover {
                box-shadow: 0 5px 16px rgba(0, 0, 0, 0.3);
            }
        }

        .dark .specialty-card-modern {
            background-color: #374151;
            border-color: #4b5563;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.2);
        }

        .dark .specialty-card-modern:hover {
            box-shadow: 0 5px 16px rgba(0, 0, 0, 0.3);
        }

        .main-specialty-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            /* تصغير المسافة */
            flex-wrap: wrap;
            gap: 10px;
            /* تصغير المسافة */
        }

        .main-specialty-header h2 {
            font-size: 1.4rem;
            /* تصغير الخط */
            font-weight: 700;
            color: #374151;
            transition: color 0.3s ease;
        }

        /* Dark mode heading 2 */
        @media (prefers-color-scheme: dark) {
            .main-specialty-header h2 {
                color: #f9fafb;
            }
        }

        .dark .main-specialty-header h2 {
            color: #f9fafb;
        }

        .action-icon-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 6px;
            /* تصغير الpadding */
            border-radius: 6px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-icon-button:hover {
            background-color: #f3f4f6;
            color: #3b82f6;
        }

        .action-icon-button.delete:hover {
            color: #dc2626;
            background-color: #fef2f2;
        }

        /* Dark mode action buttons */
        @media (prefers-color-scheme: dark) {
            .action-icon-button {
                color: #9ca3af;
            }

            .action-icon-button:hover {
                background-color: #4b5563;
                color: #60a5fa;
            }

            .action-icon-button.delete:hover {
                background-color: #7f1d1d;
                color: #f87171;
            }
        }

        .dark .action-icon-button {
            color: #9ca3af;
        }

        .dark .action-icon-button:hover {
            background-color: #4b5563;
            color: #60a5fa;
        }

        .dark .action-icon-button.delete:hover {
            background-color: #7f1d1d;
            color: #f87171;
        }

        .sub-specialty-toggle {
            font-size: 0.85rem;
            /* تصغير الخط */
            font-weight: 600;
            color: #3b82f6;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            /* تصغير المسافة */
            margin-top: 10px;
            /* تصغير المسافة */
            transition: color 0.2s ease;
        }

        .sub-specialty-toggle:hover {
            color: #2563eb;
        }

        /* Dark mode toggle */
        .dark .sub-specialty-toggle {
            color: #60a5fa;
        }

        .dark .sub-specialty-toggle:hover {
            color: #93c5fd;
        }

        .sub-specialties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            /* تصغير العرض */
            gap: 8px;
            /* تصغير المسافة */
            padding-top: 10px;
            /* تصغير المسافة */
        }

        .sub-specialty-chip {
            background-color: #eff6ff;
            color: #1e40af;
            padding: 6px 10px;
            /* تصغير الpadding */
            border-radius: 16px;
            /* تصغير الحواف */
            font-size: 0.8rem;
            /* تصغير الخط */
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            /* تصغير المسافة */
            transition: all 0.2s ease;
        }

        .sub-specialty-chip:hover {
            background-color: #dbeafe;
            transform: translateY(-1px);
        }

        /* Dark mode chip */
        @media (prefers-color-scheme: dark) {
            .sub-specialty-chip {
                background-color: #1e3a8a;
                color: #bfdbfe;
            }

            .sub-specialty-chip:hover {
                background-color: #1e40af;
            }
        }

        .dark .sub-specialty-chip {
            background-color: #1e3a8a;
            color: #bfdbfe;
        }

        .dark .sub-specialty-chip:hover {
            background-color: #1e40af;
        }

        .chip-actions {
            display: flex;
            gap: 3px;
            /* تصغير المسافة */
        }

        .chip-action-icon {
            color: #6b7280;
            cursor: pointer;
            transition: color 0.2s ease;
            font-size: 0.75rem;
            /* تصغير الأيقونات */
        }

        .chip-action-icon:hover {
            color: #3b82f6;
        }

        .chip-action-icon.delete:hover {
            color: #dc2626;
        }

        /* Dark mode chip actions */
        .dark .chip-action-icon {
            color: #9ca3af;
        }

        .dark .chip-action-icon:hover {
            color: #60a5fa;
        }

        .dark .chip-action-icon.delete:hover {
            color: #f87171;
        }

        .empty-state-modern {
            text-align: center;
            padding: 40px 20px;
            /* تصغير الpadding */
            color: #6b7280;
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            background-color: #fefefe;
            margin-top: 20px;
            /* تصغير المسافة */
            transition: all 0.3s ease;
        }

        .empty-state-modern svg {
            width: 50px;
            /* تصغير الأيقونة */
            height: 50px;
            margin: 0 auto 15px;
            /* تصغير المسافة */
            color: #9ca3af;
        }

        .empty-state-modern h3 {
            font-size: 1.4rem;
            /* تصغير الخط */
            color: #374151;
            margin-bottom: 8px;
            /* تصغير المسافة */
            transition: color 0.3s ease;
        }

        .empty-state-modern p {
            font-size: 0.95rem;
            /* تصغير الخط */
            margin-bottom: 20px;
            /* تصغير المسافة */
        }

        /* Dark mode empty state */
        @media (prefers-color-scheme: dark) {
            .empty-state-modern {
                background-color: #374151;
                border-color: #4b5563;
                color: #9ca3af;
            }

            .empty-state-modern h3 {
                color: #f9fafb;
            }

            .empty-state-modern svg {
                color: #6b7280;
            }
        }

        .dark .empty-state-modern {
            background-color: #374151;
            border-color: #4b5563;
            color: #9ca3af;
        }

        .dark .empty-state-modern h3 {
            color: #f9fafb;
        }

        .dark .empty-state-modern svg {
            color: #6b7280;
        }

        /* Collapse animation */
        .collapse-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .collapse-content.show {
            max-height: 400px;
            /* تصغير الارتفاع */
        }

        /* Small description text styles */
        .specialty-description {
            color: #6b7280;
            font-size: 0.8rem;
            /* تصغير الخط */
            margin-top: 2px;
            transition: color 0.3s ease;
        }

        .dark .specialty-description {
            color: #9ca3af;
        }

        /* Badge styles */
        .count-badge {
            background-color: #f3f4f6;
            color: #6b7280;
            font-size: 0.7rem;
            /* تصغير الخط */
            padding: 2px 6px;
            /* تصغير الpadding */
            border-radius: 10px;
            margin-right: 4px;
            transition: all 0.3s ease;
        }

        .dark .count-badge {
            background-color: #4b5563;
            color: #d1d5db;
        }

        /* Enhanced icon styles */
        .icon-blue {
            color: #3b82f6;
            transition: color 0.3s ease;
        }

        .dark .icon-blue {
            color: #60a5fa;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container-modern {
                margin: 10px;
                padding: 15px;
            }

            .header-modern {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header-modern>div {
                width: 100%;
            }

            .header-modern .flex-col {
                width: 100%;
                align-items: stretch;
            }

            .search-input-modern,
            .button-modern {
                max-width: 100%;
                width: 100%;
            }

            .main-specialty-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .sub-specialties-grid {
                grid-template-columns: 1fr;
            }

            .header-modern h1 {
                font-size: 1.5rem;
            }

            .main-specialty-header h2 {
                font-size: 1.2rem;
            }
        }

        /* Loading animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Focus styles for better accessibility */
        .search-input-modern:focus,
        .button-modern:focus,
        .action-icon-button:focus,
        .sub-specialty-toggle:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        .dark .search-input-modern:focus,
        .dark .button-modern:focus,
        .dark .action-icon-button:focus,
        .dark .sub-specialty-toggle:focus {
            outline-color: #60a5fa;
        }

        /* Smooth transitions for theme switching */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
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

            <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                {{-- Search Box --}}
                <input type="text" id="searchBox" class="search-input-modern"
                    placeholder="{{ app()->getLocale() === 'ar' ? 'البحث في التخصصات...' : 'Search specialties...' }}">

                {{-- Add New Button --}}
                <a href="{{ route('admin.technicians.specialties.create') }}" class="button-modern">
                    <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
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
                                <svg class="w-5 h-5 icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                {{ $main->name }}
                            </h2>
                            @if ($main->description)
                                <p class="specialty-description">{{ $main->description }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.technicians.specialties.edit', $main->id) }}"
                                class="action-icon-button">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <form action="{{ route('admin.technicians.specialties.destroy', $main->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد أنك تريد حذف هذا التخصص الرئيسي؟ سيتم حذف جميع التخصصات الفرعية المرتبطة به.' : 'Are you sure you want to delete this main specialty? All associated sub-specialties will also be deleted.' }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon-button delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <div class="mt-3">
                            <button type="button" class="sub-specialty-toggle"
                                onclick="toggleSubSpecialties(this, 'sub-content-{{ $main->id }}')">
                                <span class="text-gray-700 dark:text-gray-300">
                                    {{ app()->getLocale() === 'ar' ? 'عرض المهام الإضافية' : 'View Sub Specialties' }}
                                    <span class="count-badge">{{ $subSpecialties->count() }}</span>
                                </span>
                                <svg class="w-3 h-3 icon-blue transition-transform duration-300 transform {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
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
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form
                                                    action="{{ route('admin.technicians.specialties.destroy', $sub->id) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا التخصص الفرعي؟' : 'Are you sure you want to delete this sub specialty?' }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="chip-action-icon delete">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <div
                            class="mt-3 p-3 bg-gray-50 dark:bg-gray-600 rounded text-center text-gray-500 dark:text-gray-400 text-xs border border-dashed border-gray-200 dark:border-gray-500">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد مهام إضافية لهذا التخصص.' : 'No sub-specialties for this main specialty.' }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state-modern">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
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
                        <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
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
                let noResultsState = null;

                if (searchBox) {
                    searchBox.addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase().trim();
                        const specialtyCards = specialtiesContainer.querySelectorAll('.specialty-card-modern');
                        let hasVisibleResults = false;

                        specialtyCards.forEach(card => {
                            const mainSpecialtyName = card.querySelector('h2').textContent
                        .toLowerCase();
                            const subSpecialtyChips = card.querySelectorAll(
                                '.sub-specialty-chip span.font-medium');

                            let isMainVisible = mainSpecialtyName.includes(searchTerm);
                            let isSubVisible = false;

                            // Check sub-specialties if main is not visible
                            if (!isMainVisible) {
                                subSpecialtyChips.forEach(chipName => {
                                    if (chipName.textContent.toLowerCase().includes(
                                        searchTerm)) {
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
                    const textSpan = button.querySelector('span');

                    if (content.classList.contains('show')) {
                        content.classList.remove('show');
                        icon.classList.remove('rotate-0');
                        if (document.dir === 'rtl') {
                            icon.classList.add('rotate-180');
                        }
                        textSpan.innerHTML = `
                            ${document.dir === 'rtl' ? 'عرض المهام الإضافية' : 'View Sub Specialties'}
                            <span class="count-badge">${content.querySelectorAll('.sub-specialty-chip').length}</span>
                        `;
                    } else {
                        content.classList.add('show');
                        icon.classList.add('rotate-0');
                        if (document.dir === 'rtl') {
                            icon.classList.remove('rotate-180');
                        }
                        textSpan.innerHTML = `
                            ${document.dir === 'rtl' ? 'إخفاء المهام الإضافية' : 'Hide Sub Specialties'}
                            <span class="count-badge">${content.querySelectorAll('.sub-specialty-chip').length}</span>
                        `;
                    }
                };

                // Add loading states to forms
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        const submitBtn = this.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.dataset.originalHtml = submitBtn.innerHTML;
                            submitBtn.disabled = true;
                            submitBtn.style.opacity = '0.7';
                            submitBtn.style.cursor = 'not-allowed';

                            if (submitBtn.classList.contains('action-icon-button') ||
                                submitBtn.classList.contains('chip-action-icon')) {
                                submitBtn.innerHTML = `
                                    <svg class="animate-spin w-3 h-3 text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                `;
                            } else {
                                submitBtn.innerHTML = `
                                    <svg class="animate-spin w-3 h-3 inline-block {{ app()->getLocale() === 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    ${document.dir === 'rtl' ? 'جاري التنفيذ...' : 'Processing...'}
                                `;
                            }
                        }
                    });
                });

                // Theme detection and handling
                function handleThemeChange() {
                    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches ||
                        document.documentElement.classList.contains('dark');

                    // Update any theme-specific elements if needed
                    const elements = document.querySelectorAll('.theme-sensitive');
                    elements.forEach(el => {
                        if (isDark) {
                            el.classList.add('dark-theme');
                        } else {
                            el.classList.remove('dark-theme');
                        }
                    });
                }

                // Listen for theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', handleThemeChange);

                // Initial theme setup
                handleThemeChange();

                // Enhanced keyboard navigation
                document.addEventListener('keydown', function(e) {
                    // Press 'S' to focus search
                    if (e.key === 's' || e.key === 'S') {
                        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                            e.preventDefault();
                            searchBox.focus();
                        }
                    }

                    // Press 'Escape' to clear search
                    if (e.key === 'Escape' && document.activeElement === searchBox) {
                        searchBox.value = '';
                        searchBox.dispatchEvent(new Event('input'));
                    }
                });

                // Add smooth scroll behavior
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Auto-save search state in localStorage
                if (searchBox) {
                    const savedSearch = localStorage.getItem('specialties_search');
                    if (savedSearch) {
                        searchBox.value = savedSearch;
                        searchBox.dispatchEvent(new Event('input'));
                    }

                    searchBox.addEventListener('input', function() {
                        localStorage.setItem('specialties_search', this.value);
                    });
                }

                // Add tooltips for action buttons
                const actionButtons = document.querySelectorAll('.action-icon-button, .chip-action-icon');
                actionButtons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        const isEdit = this.href && this.href.includes('edit');
                        const isDelete = this.classList.contains('delete');

                        let tooltipText = '';
                        if (isEdit) {
                            tooltipText = document.dir === 'rtl' ? 'تعديل' : 'Edit';
                        } else if (isDelete) {
                            tooltipText = document.dir === 'rtl' ? 'حذف' : 'Delete';
                        }

                        if (tooltipText) {
                            this.title = tooltipText;
                        }
                    });
                });

                // Performance optimization: Debounce search
                let searchTimeout;
                if (searchBox) {
                    const originalHandler = searchBox.oninput;
                    searchBox.oninput = null;

                    searchBox.addEventListener('input', function(e) {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            // Trigger the original search logic
                            const event = new Event('input');
                            this.dispatchEvent(event);
                        }, 150); // 150ms debounce
                    });
                }
            });

            // Utility function for smooth animations
            function animateElement(element, animation, duration = 300) {
                return new Promise((resolve) => {
                    element.style.animation = `${animation} ${duration}ms ease-out`;
                    setTimeout(() => {
                        element.style.animation = '';
                        resolve();
                    }, duration);
                });
            }

            // Add intersection observer for fade-in animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all specialty cards
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.specialty-card-modern');
                cards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition =
                        `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                    observer.observe(card);
                });
            });
        </script>
    @endpush
@endsection
