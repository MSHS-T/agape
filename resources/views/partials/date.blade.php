@php
    $empty = true;
    if(isset($date)){
        $type = "date";
        $value = $date;
        $empty = false;
    } else if(isset($datetime)){
        $type = "datetime";
        $value = $datetime;
        $empty = false;
    }
@endphp
@if(!$empty)
    {{ \Carbon\Carbon::parse($value)->format($format ?? __("locale." . $type . "_format")) }}
@else
    {{ __('fields.never') }}
@endif
