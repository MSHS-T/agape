@php
$id = 'input'.ucfirst(camel_case($name));
@endphp
<div class="form-group row">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        <textarea class="form-control" id="{{$id}}" name="{{$name}}" placeholder="{{$label}}" rows={{$rows??3}}>
            {{$value}}
        </textarea>
        @if(isset($help))
        <small id="{{$id}}HelpBlock" class="form-text text-muted">
            {!! $help !!}
        </small>
        @endif
    </div>
</div>
