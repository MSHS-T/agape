@php
    $id0    = 'input'.ucfirst(camel_case($name[0]));
    $id1    = 'input'.ucfirst(camel_case($name[0]));
    $readonly = $readonly ?? false;
@endphp
<div class="form-group row">
    <label for="{{$id0}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        <div class="row">
            <div class="col">
                <input
                    type="date"
                    class="form-control form-datepicker"
                    id="{{$id0}}"
                    name="{{ $name[0] }}"
                    value="{{ $value[0] }}"
                    @if($readonly) readonly @endif
                    @if(isset($tabindex)) tabindex="{{ $tabindex }}" @endif
                >
            </div>
            <div class="col-1 col-form-label text-center">&nbsp;&rarr;&nbsp;</div>
            <div class="col">
                <input
                    type="date"
                    class="form-control form-datepicker"
                    id="{{$id1}}"
                    name="{{ $name[1] }}"
                    value="{{ $value[1] }}"
                    @if($readonly) readonly @endif
                    @if(isset($tabindex)) tabindex="{{ $tabindex }}" @endif
                >
            </div>
        </div>
        @if(isset($help))
            <small id="{{$id0}}HelpBlock" class="form-text text-muted">
                {!! $help !!}
            </small>
        @endif
    </div>
</div>
