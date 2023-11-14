<div class="flex items-stretch space-x-2 py-1 text-sm">
    <div class="flex flex-col items-stretch space-y-1">
        <div class="font-semibold underline text-right">
            {{ __('resources.application') }} :
        </div>
        <div class="font-semibold underline text-right">
            {{ __('resources.evaluation') }} :
        </div>
    </div>
    <div class="flex flex-col items-stretch space-y-1">
        <span>
            {{ $getRecord()->application_start_date->format(__('misc.date_format')) }}
        </span>
        <span>
            {{ $getRecord()->evaluation_start_date->format(__('misc.date_format')) }}
        </span>
    </div>
    <div class="flex flex-col justify-evenly items-stretch space-y-1">
        <x-fas-arrow-right class="h-4 w-4" />
        <x-fas-arrow-right class="h-4 w-4" />
    </div>
    <div class="flex flex-col items-stretch space-y-1">
        <span>
            {{ $getRecord()->application_end_date->format(__('misc.date_format')) }}
        </span>
        <span>
            {{ $getRecord()->evaluation_end_date->format(__('misc.date_format')) }}
        </span>
    </div>
</div>
