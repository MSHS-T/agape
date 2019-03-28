@php
    $id = 'input'.ucfirst(camel_case($name));
    if($multiple) {
        $name = $name."[]";
    }
    if(!isset($value) || is_null($value) || empty($value)) {
        $value = [];
    }
    else if(!is_iterable($value)) {
        $value = [$value];
    }
@endphp
<div class="form-group row">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        @foreach($value as $v)
            {{ __('fields.download_link') }} :
            <a href="{{ route('download.attachment', ['application_id' => $v->application_id, 'index' => $v->order]) }}"
                target="_blank" rel="noopener">{{ $v->name }}</a>
            <br />
        @endforeach
        <input
            type="file"
            id="{{$id}}"
            name="{{$name}}"
            @if($multiple) multiple @endif
            @if(isset($accept)) accept="{{$accept}}" @endif
        >
        @if($help)
            <small id="{{$id}}HelpBlock" class="form-text text-muted">
                @if(isset($accept))
                    {{__('fields.upload_extensions')}} : {{ str_replace(',', ', ', $accept) }}<br />
                @endif
                {!! __('fields.upload_overwrite' . ($multiple ? '_multiple' : '')) !!}
            </small>
        @endif
    </div>
</div>
