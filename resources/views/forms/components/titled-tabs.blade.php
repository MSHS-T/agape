@php
    use Filament\Support\Enums\IconSize;
@endphp

@php
    $collapsed = $isCollapsed();
    $collapsible = $isCollapsible();
    $description = $getDescription();
    $heading = $getHeading();
    $icon = $getIcon();
    $iconColor = $getIconColor();
    $iconSize = $getIconSize() ?? IconSize::Large;

    $hasDescription = filled((string) $description);
    $hasHeading = filled($heading);
    $hasIcon = filled($icon);
    $hasHeader = $hasIcon || $hasHeading || $hasDescription || $collapsible;
@endphp
<section x-data="{
    isCollapsed: @js($collapsed),
    tab: null,

    init: function() {
        this.$watch('tab', () => this.updateQueryString())

        this.tab = this.getTabs()[@js($getActiveTab()) - 1]
    },

    getTabs: function() {
        return JSON.parse(this.$refs.tabsData.value)
    },

    updateQueryString: function() {
        if (!@js($isTabPersistedInQueryString())) {
            return
        }

        const url = new URL(window.location.href)
        url.searchParams.set(@js($getTabQueryStringKey()), this.tab)

        history.pushState(null, document.title, url.toString())
    },
}" @if ($collapsible)
    x-on:collapse-section.window="if ($event.detail.id == $el.id) isCollapsed = true"
    x-on:expand-concealing-component.window="
            $nextTick(() => {
                error = $el.querySelector('[data-validation-error]')

                if (! error) {
                    return
                }

                isCollapsed = false

                if (document.body.querySelector('[data-validation-error]') !== error) {
                    return
                }

                setTimeout(
                    () =>
                        $el.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                            inline: 'start',
                        }),
                    200,
                )
            })
        "
    x-on:open-section.window="if ($event.detail.id == $el.id) isCollapsed = false"
    x-on:toggle-section.window="if ($event.detail.id == $el.id) isCollapsed = ! isCollapsed"
    x-bind:class="isCollapsed && 'fi-collapsed'" @endif
    {{ $attributes->merge(
            [
                'id' => $getId(),
                'wire:key' => "{$this->getId()}.{$getStatePath()}." . \Filament\Forms\Components\Tabs::class . '.container',
            ],
            escape: false,
        )->merge($getExtraAttributes(), escape: false)->merge($getExtraAlpineAttributes(), escape: false)->class([
            'fi-section',
            'fi-fo-tabs flex flex-col',
            'fi-contained rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10' => $isContained,
            'rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
        ]) }}
    >
    @if ($hasHeader)
        <header @if ($collapsible) x-on:click="isCollapsed = ! isCollapsed" @endif
            @class([
                'fi-section-header flex items-center gap-x-3 overflow-hidden',
                'px-6 py-4',
                'cursor-pointer' => $collapsible,
            ])>
            @if ($hasIcon)
                <x-filament::icon :icon="$icon" @class([
                    'fi-section-header-icon',
                    'fi-color-gray text-gray-400 dark:text-gray-500',
                    match ($iconSize) {
                        IconSize::Small, 'sm' => 'h-4 w-4 mt-1',
                        IconSize::Medium, 'md' => 'h-5 w-5 mt-0.5',
                        IconSize::Large, 'lg' => 'h-6 w-6',
                        default => $iconSize,
                    },
                ]) @style([
                    \Filament\Support\get_color_css_variables($iconColor, shades: [400, 500]) => $iconColor !== 'gray',
                ]) />
            @endif

            @if ($hasHeading || $hasDescription)
                <div class="grid gap-y-1">
                    @if ($hasHeading)
                        <x-filament::section.heading>
                            {{ $heading }}
                        </x-filament::section.heading>
                    @endif

                    @if ($hasDescription)
                        <x-filament::section.description>
                            {!! $description !!}
                        </x-filament::section.description>
                    @endif
                </div>
            @endif

            <input type="hidden"
                value="{{ collect($getChildComponentContainer()->getComponents())->filter(static fn(\Filament\Forms\Components\Tabs\Tab $tab): bool => $tab->isVisible())->map(static fn(\Filament\Forms\Components\Tabs\Tab $tab) => $tab->getId())->values()->toJson() }}"
                x-ref="tabsData" />

            <div class="w-8"></div>

            <x-filament::tabs :contained="$isContained" :label="$getLabel()">
                @foreach ($getChildComponentContainer()->getComponents() as $tab)
                    @php
                        $tabId = $tab->getId();
                    @endphp

                    <x-filament::tabs.item :alpine-active="'tab === \'' . $tabId . '\''" :badge="$tab->getBadge()" :icon="$tab->getIcon()" :icon-position="$tab->getIconPosition()"
                        :x-on:click.stop="'tab = \'' . $tabId . '\''">
                        {{ $tab->getLabel() }}
                    </x-filament::tabs.item>
                @endforeach
            </x-filament::tabs>

            <div class="flex-1"></div>

            @if ($collapsible)
                <x-filament::icon-button color="gray" icon="heroicon-m-chevron-down"
                    icon-alias="section.collapse-button" x-on:click.stop="isCollapsed = ! isCollapsed"
                    x-bind:class="{ 'rotate-180': !isCollapsed }" class="-m-2" />
            @endif
        </header>
    @endif

    <div @if ($collapsible) x-bind:aria-expanded="(! isCollapsed).toString()"
            @if ($collapsed)
                x-cloak @endif
        x-bind:class="{ 'invisible h-0 overflow-y-hidden border-none': isCollapsed }" @endif
        @class([
            'fi-section-content-ctn',
            'border-t border-gray-200 dark:border-white/10' => $hasHeader,
        ])
        >
        <div @class(['fi-section-content', 'p-6'])>
            @foreach ($getChildComponentContainer()->getComponents() as $tab)
                {{ $tab }}
            @endforeach
        </div>
    </div>
</section>
