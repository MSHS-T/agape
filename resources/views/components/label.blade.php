@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm leading-6 text-gray-900 dark:text-gray-100']) }}>
    {{ $value ?? $slot }}
</label>
