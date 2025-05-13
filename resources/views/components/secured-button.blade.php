@props(['permission', 'href'])

@can($permission)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm shadow']) }}>
        {{ $slot }}
    </a>
@endcan
