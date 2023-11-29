@php
    $notationGrid = $record->evaluationOffer->application->projectCall->notation;
    $generalSettings = app(\App\Settings\GeneralSettings::class);
    $getGradeLabel = fn($grade) => collect($generalSettings->grades)->first(fn($g) => $g['grade'] === $grade)['label'][app()->getLocale()];
@endphp
@foreach ($notationGrid as $criteriaIndex => $criteria)
    <x-filament::section>
        <x-slot name="heading">
            {{ $criteria['title'][app()->getLocale()] }}
        </x-slot>
        <div class="flex flex-col items-stretch space-y-2">
            <div class="flex items-center justify-start">
                <span class="basis-1/4 font-bold underline">{{ __('pages.evaluate.grade') }}</span>
                <span class="flex-1">
                    {{ $record->grades[$criteriaIndex] . ' - ' . $getGradeLabel($record->grades[$criteriaIndex]) }}
                </span>
            </div>
            <div class="flex items-center justify-start">
                <span class="basis-1/4 font-bold underline">{{ __('pages.evaluate.comment') }}</span>
                <div
                    class="flex-1 text-gray-700 dark:text-gray-200 prose prose-headings:text-gray-900 prose-headings:dark:text-white prose-a:text-gray-900 prose-a:dark:text-white prose-strong:text-gray-900 prose-strong:dark:text-white">
                    {!! $record->comments[$criteriaIndex] !!}
                </div>
            </div>
        </div>
    </x-filament::section>
@endforeach
<x-filament::section>
    <x-slot name="heading">
        {{ __('pages.evaluate.global_grade') }}
    </x-slot>
    <div class="flex flex-col items-stretch space-y-2">
        <div class="flex items-center justify-start">
            <span class="basis-1/4 font-bold underline">{{ __('pages.evaluate.global_grade') }}</span>
            <span class="flex-1">
                {{ $record->global_grade . ' - ' . $getGradeLabel($record->global_grade) }}
            </span>
        </div>
        <div class="flex items-center justify-start">
            <span class="basis-1/4 font-bold underline">{{ __('pages.evaluate.global_comment') }}</span>
            <div
                class="flex-1 text-gray-700 dark:text-gray-200 prose prose-headings:text-gray-900 prose-headings:dark:text-white prose-a:text-gray-900 prose-a:dark:text-white prose-strong:text-gray-900 prose-strong:dark:text-white">
                {!! $record->global_comment !!}
            </div>
        </div>
    </div>
</x-filament::section>
