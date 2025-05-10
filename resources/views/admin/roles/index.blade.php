@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان وزر الإضافة --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.roles_list') }}</h1>
        <a href="{{ route('admin.roles.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow">
            + {{ __('messages.add_role') }}
        </a>
    </div>

    {{-- عرض المجموعات --}}
    @if ($roles->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_roles') }}
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($roles as $role)
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200 relative group flex flex-col justify-between">

                    {{-- اسم المجموعة --}}
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $role->name }}</h2>

                    {{-- زر عرض الصلاحيات --}}
                    <div class="mb-4">
                        <button type="button"
                            class="w-full flex justify-between items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 text-sm rounded shadow"
                            onclick="toggleDropdown('dropdown-{{ $role->id }}')">
                            {{ __('messages.view_permissions') }}
                            <svg class="w-4 h-4 transform transition-transform duration-200 group-hover:rotate-180"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5"/>
                            </svg>
                        </button>
                        <div id="dropdown-{{ $role->id }}"
                             class="hidden mt-2 bg-white border border-gray-200 rounded shadow p-3 text-sm max-h-40 overflow-auto z-10">
                            @forelse ($role->permissions as $perm)
                                <div class="text-gray-600">{{ __('permissions.' . $perm->name) ?? $perm->name }}</div>
                            @empty
                                <div class="text-gray-400 italic">{{ __('messages.no_permissions') }}</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- أزرار التعديل والحذف --}}
                    <div class="flex justify-between items-center border-t pt-3">
                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            {{ __('messages.edit') }}
                        </a>
                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                              onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-sm text-red-600 hover:text-red-800 font-medium">
                                {{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

{{-- سكريبت القوائم المنسدلة --}}
<script>
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
    }
</script>
@endsection
