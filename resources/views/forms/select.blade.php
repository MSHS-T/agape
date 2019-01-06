@php
$id = 'input'.ucfirst(camel_case($name));
@endphp
<div class="form-group row">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        <select class="form-control" id="{{$id}}" name="{{$name}}">
            <option value="none" @if (!$allowNone) disabled @endif selected>{{__('fields.none')}}</option>
            @foreach($allowedValues as $v)
            @php
            $valueVal = $v->{$valueField};
            $displayVal = $v->{$displayField};
            @endphp
            <option value="{{ $valueVal }}">{{ $displayVal }}</option>
            @endforeach
        </select>
        @if(isset($help))
        <small id="{{$id}}HelpBlock" class="form-text text-muted">
            {!! $help !!}
        </small>
        @endif
    </div>
</div>
