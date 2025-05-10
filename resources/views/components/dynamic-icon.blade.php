@php
    $componentName = 'heroicon-o-' . $icon;
@endphp

<x-dynamic-component :component="$componentName" :class="$class" />
