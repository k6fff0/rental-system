@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- العنوان وزر إضافة مستخدم --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('messages.users_list') }}</h1>

        <a href="{{ route('admin.users.create') }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold shadow">
            + {{ __('messages.add_user') }}
        </a>
    </div>

    {{-- عرض المستخدمين --}}
    @if ($users->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            {{ __('messages.no_users') }}
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($users as $user)
                <div class="bg-white p-6 rounded-lg shadow border flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-600 mb-1">{{ $user->email }}</p>

                        {{-- المجموعة --}}
                        <p class="text-sm text-gray-700">
                            <strong>{{ __('messages.role') }}:</strong>
                            {{ $user->roles->pluck('name')->join(', ') ?: __('messages.no_role_assigned') }}
                        </p>

                        {{-- الصلاحيات المختصرة --}}
                        @php
                            $permissions = $user->getAllPermissions()->pluck('name');
                        @endphp

                        @if ($permissions->isNotEmpty())
                            <p class="text-sm text-gray-700 mt-2">
                                <strong>{{ __('messages.permissions') }}:</strong>
                                <span class="block text-xs text-gray-600">
                                    {{ $permissions->take(4)->join(', ') }}
                                    @if ($permissions->count() > 4)
                                        +{{ $permissions->count() - 4 }} {{ __('messages.more') }}
                                    @endif
                                </span>
                            </p>
                        @endif
                    </div>

                    {{-- أزرار التحكم داخل إطار منظم --}}
                    <div class="mt-4">
                        <div class="bg-gray-100 rounded-md p-2 flex justify-between items-center gap-3">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded font-semibold">
                                {{ __('messages.edit') }}
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-sm bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded font-semibold">
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
