@props(['color' => 'primary', 'class' => '', 'tag' => 'button'])

@php
    $colorClass = match ($color) {
        'danger' => 'bg-red-600 hover:bg-red-700 focus-visible:outline-red-600 text-white',
        'warning' => 'bg-orange-600 hover:bg-orange-700 focus-visible:outline-orange-600 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 focus-visible:outline-green-600 text-white',
        'info' => 'bg-cyan-600 hover:bg-cyan-700 focus-visible:outline-cyan-600 text-white',
        'gray' => 'bg-slate-600 hover:bg-slate-700 focus-visible:outline-slate-600 text-white',
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 focus-visible:outline-indigo-600 text-white',
    };
@endphp

<{{ $tag }}
    {{ $attributes->class(['inline-flex justify-center items-center px-4 py-2 rounded-md font-semibold text-sm leading-6 shadow-sm', $colorClass, $class])->merge(['type' => 'button']) }}>
    {{ $slot }}
    </{{ $tag }}>
