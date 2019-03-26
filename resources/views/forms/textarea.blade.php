@php
$id = 'input'.ucfirst(camel_case($name));
$row = $row ?? true;
@endphp
<div class="form-group {{ $row ? "row" : "" }}">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        {{-- <textarea class="form-control" id="{{$id}}" name="{{$name}}" placeholder="{{$label}}" rows={{$rows??3}}>{{$value}}</textarea> --}}
        <input type="hidden" name="{{$name}}">
        <div class="quill-container" id="{{$id}}" data-placeholder="{{$label}}" data-rows="{{$rows??3}}">
            <p>{!! ($value ?? "") !!}</p>
        </div>
        @if(isset($help))
        <small id="{{$id}}HelpBlock" class="form-text text-muted">
            {!! $help !!}
        </small>
        @endif
    </div>
</div>
