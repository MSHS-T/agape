@php
    if(isset($date)){
        $type = "date";
        $value = $date;
    } else if(isset($datetime)){
        $type = "datetime";
        $value = $datetime;
    }
    $defaultFormat = "locale." . $type . "_format";
@endphp
{{
    \Carbon\Carbon::parse($value)
                  ->format($format ?? __($defaultFormat))
}}