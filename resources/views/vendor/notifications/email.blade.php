<x-mail::message>
{{-- Greeting --}}
@if (!empty($greeting))
# {!! $greeting !!}
@else
@if ($level === 'error')
    # @lang('email.greeting_error')
@else
    # @lang('email.greeting')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{!! $line !!}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
$color = match ($level) {
    'success', 'error' => $level,
    default => 'primary',
};
?>
<x-mail::button :url="$actionUrl" :color="$color">
    {!! $actionText !!}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{!! $line !!}
@endforeach

{{-- Salutation --}}
@if (!empty($salutation))
{{ $salutation }}
@else
@lang('email.regards')<br>
@lang('email.signature', ['app_name' => config('app.name')])
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
    @lang('email.trouble_clicking', ['actionText' => $actionText, 'actionURL' => $actionUrl])
</x-slot:subcopy>
@endisset
</x-mail::message>
