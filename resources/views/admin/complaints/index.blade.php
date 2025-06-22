@extends('layouts.app')
@section('title', 'الشكاوى')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-xl">
                            <i class="fas fa-envelope-open-text text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                                إدارة الشكاوى
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                عرض ومتابعة جميع الشكاوى الواردة من العملاء
                            </p>
                        </div>
                    </div>
                    <div class="text-left rtl:text-right">
                        <div
                            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl shadow-lg">
                            <div class="text-2xl font-bold">{{ $complaints->total() }}</div>
                            <div class="text-sm opacity-90">إجمالي الشكاوى</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mb-8">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex-1 min-w-64">
                        <input type="text" id="searchInput" placeholder="البحث في الشكاوى..."
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-search"></i>
                        بحث
                    </button>
                    <button
                        class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-xl transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        فلتر
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-right font-semibold">#</th>
                                <th class="px-6 py-4 text-right font-semibold">الاسم</th>
                                <th class="px-6 py-4 text-right font-semibold">الهاتف</th>
                                <th class="px-6 py-4 text-right font-semibold">البريد الإلكتروني</th>
                                <th class="px-6 py-4 text-right font-semibold">ملخص الشكوى</th>
                                <th class="px-6 py-4 text-right font-semibold">التاريخ</th>
                                <th class="px-6 py-4 text-right font-semibold">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($complaints as $index => $complaint)
                                <tr
                                    class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-300 cursor-pointer">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $complaints->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($complaint->name, 0, 1) }}
                                            </div>
                                            <div class="mr-3">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $complaint->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-green-500 ml-2"></i>
                                            {{ $complaint->phone }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-blue-500 ml-2"></i>
                                            {{ $complaint->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="max-w-xs">
                                            {{ Str::limit($complaint->message, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-gray-400 ml-2"></i>
                                            {{ $complaint->created_at->format('Y-m-d') }}
                                            <br>
                                            <span class="text-xs">{{ $complaint->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2 rtl:space-x-reverse">
                                            <button onclick="openComplaintModal({{ json_encode($complaint) }})"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-xs transition-all duration-300 flex items-center gap-1">
                                                <i class="fas fa-eye"></i>
                                                عرض
                                            </button>
                                            <button
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-xs transition-all duration-300 flex items-center gap-1">
                                                <i class="fas fa-reply"></i>
                                                رد
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-400 mb-2">
                                                لا توجد شكاوى
                                            </h3>
                                            <p class="text-gray-500 dark:text-gray-500">
                                                لم يتم استلام أي شكاوى حتى الآن
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($complaints->hasPages())
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Complaint Details Modal -->
    <div id="complaintModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" onclick="closeComplaintModal()"></div>

            <!-- Modal content -->
            <div
                class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-right transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl align-middle">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-file-alt text-indigo-500 ml-3"></i>
                        تفاصيل الشكوى
                    </h3>
                    <button onclick="closeComplaintModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="mt-6 space-y-6">
                    <!-- Customer Info -->
                    <div
                        class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-user text-blue-500 ml-2"></i>
                            معلومات العميل
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300 ml-2">الاسم:</span>
                                <span id="modalName" class="text-gray-800 dark:text-white"></span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300 ml-2">الهاتف:</span>
                                <span id="modalPhone" class="text-gray-800 dark:text-white"></span>
                            </div>
                            <div class="flex items-center md:col-span-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300 ml-2">البريد:</span>
                                <span id="modalEmail" class="text-gray-800 dark:text-white"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Complaint Details -->
                    <div
                        class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-exclamation-circle text-yellow-500 ml-2"></i>
                            تفاصيل الشكوى
                        </h4>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border-r-4 border-yellow-400">
                            <p id="modalMessage" class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm"></p>
                        </div>
                    </div>

                    <!-- Date Info -->
                    <div
                        class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-clock text-green-500 ml-2"></i>
                            معلومات التاريخ
                        </h4>
                        <div class="flex items-center">
                            <span class="font-medium text-gray-600 dark:text-gray-300 ml-2">تاريخ الإرسال:</span>
                            <span id="modalDate" class="text-gray-800 dark:text-white"></span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex space-x-3 rtl:space-x-reverse">
                        <button
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-reply"></i>
                            الرد على الشكوى
                        </button>
                        <button
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-print"></i>
                            طباعة
                        </button>
                    </div>
                    <button onclick="closeComplaintModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition-all duration-300">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openComplaintModal(complaint) {
            document.getElementById('modalName').textContent = complaint.name;
            document.getElementById('modalPhone').textContent = complaint.phone;
            document.getElementById('modalEmail').textContent = complaint.email;
            document.getElementById('modalMessage').textContent = complaint.message;

            // Format date
            const date = new Date(complaint.created_at);
            const formattedDate = date.toLocaleDateString('ar-EG') + ' - ' + date.toLocaleTimeString('ar-EG', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalDate').textContent = formattedDate;

            document.getElementById('complaintModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeComplaintModal() {
            document.getElementById('complaintModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeComplaintModal();
            }
        });
    </script>

    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        /* RTL support */
        [dir="rtl"] .space-x-reverse>*+* {
            margin-right: 0.5rem;
            margin-left: 0;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endsection
