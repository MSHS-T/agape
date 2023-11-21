@php
    use Filament\Support\Enums\VerticalAlignment;

    $verticalAlignment = $getVerticalAlignment();

    if (!$verticalAlignment instanceof VerticalAlignment) {
        $verticalAlignment = VerticalAlignment::tryFrom($verticalAlignment) ?? $verticalAlignment;
    }
@endphp

<div class="w-full max-w-7xl fixed bottom-4 pr-4 md:pr-6 lg:pr-16">
    <div
        {{ $attributes->merge(
                [
                    'id' => $getId(),
                ],
                escape: false,
            )->merge($getExtraAttributes(), escape: false)->class([
                'fi-fo-actions py-4 flex flex-col rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
                match ($verticalAlignment) {
                    VerticalAlignment::Start => 'justify-start',
                    VerticalAlignment::Center => 'justify-center',
                    VerticalAlignment::End => 'justify-end',
                    default => $verticalAlignment,
                },
            ]) }}>
        <x-filament-actions::actions :actions="$getChildComponentContainer()->getComponents()" :alignment="$getAlignment()" :full-width="$isFullWidth()" />
    </div>
</div>
