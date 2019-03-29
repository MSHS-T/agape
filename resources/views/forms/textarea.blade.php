@php
    $id = 'input'.ucfirst(camel_case($name));
    $row = $row ?? true;
@endphp
<div class="form-group {{ $row ? "row" : "" }}">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        <input type="hidden" name="{{$name}}" value="{{$value ?? ""}}">
        <div
            class="quill-container"
            id="{{$id}}"
            data-placeholder="{{$label}}"
            style="height:{{($rows??5)*1.5}}rem;"
            @if(isset($tabindex)) data-tabindex="{{ $tabindex }}" @endif
        >
            <p>{!! ($value ?? "") !!}</p>
        </div>
        @if(isset($help))
            <small id="{{$id}}HelpBlock" class="form-text text-muted">
                {!! $help !!}
            </small>
        @endif
    </div>
</div>
