@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        {{-- العنوان وزر الإضافة --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.permissions_list') }}</h1>
            <a href="{{ route('admin.permissions.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md text-sm font-semibold shadow">
                + {{ __('messages.add_permission') }}
            </a>
        </div>

        {{-- عرض الصلاحيات --}}
        @if ($permissions->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                {{ __('messages.no_permissions') }}
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($permissions as $permission)
                    <div class="bg-white p-6 rounded-xl shadow border border-gray-200 flex flex-col justify-between">

                        {{-- اسم الصلاحية --}}
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $permission->name }}</h2>

                        {{-- أزرار التحكم --}}
                        <div class="flex justify-between items-center border-t pt-3 mt-auto">
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                {{ __('messages.edit') }}
                            </a>

                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST"
                                onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
