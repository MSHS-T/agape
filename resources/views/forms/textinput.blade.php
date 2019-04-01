@php
    $id    = 'input'.ucfirst(camel_case($name));
    $money = false;
    $type  = $type ?? 'text';
    $readonly = $readonly ?? false;
    $disabled = $disabled ?? false;
    if($type == "money"){
        $type  = "number";
        $step  = 0.01;
        $min   = 0;
        $money = true;
    }
@endphp
<div class="form-group row">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        @if($money)
            <div class="input-group">
        @endif
            <input
                type="{{ $type ?? 'text' }}"
                class="form-control"
                id="{{$id}}"
                name="{{$name}}"
                placeholder="{{$label}}"
                value="{{$value}}"
                @if (isset($tabindex)) tabindex="{{ $tabindex }}" @endif
                @if (isset($step)) step="{{ $step }}" @endif
                @if (isset($min)) min="{{ $min }}" @endif
                @if ($readonly) readonly @endif
                @if ($disabled) disabled @endif
            >
        @if($money)
                <div class="input-group-append">
                    <span class="input-group-text">{{ __('locale.currency') }}</span>
                </div>
            </div>
        @endif
        @if(isset($help))
            <small id="{{$id}}HelpBlock" class="form-text text-muted">
                {!! $help !!}
            </small>
        @endif
    </div>
</div>
