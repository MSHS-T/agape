@php
    $id = 'input'.ucfirst(camel_case($name));
@endphp
<input type="hidden" id="{{$id}}" name="{{$name}}" value="{{$value}}">
