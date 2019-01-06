@php
$id = 'input'.ucfirst(camel_case($name));
if($multiple){
$name = $name."[]";
}
@endphp
<div class="form-group row">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        @if(!is_null($value) & !empty($value))
        @foreach($value as $v)
        {{ __('fields.download_link') }} : <a href="{{ route('download.attachment', ['application_id' => $v->application_id, 'index' => $v->order]) }}"
            target="_blank" rel="noopener">{{ $v->name }}</a>
        @endforeach
        @endif
        <input type="file" id="{{$id}}" name="{{$name}}" @if($multiple) multiple @endif>
        @if($help)
        <small id="{{$id}}HelpBlock" class="form-text text-muted">
            {!! __('fields.upload_overwrite' . ($multiple ? '_multiple' : '')) !!}
        </small>
        @endif
    </div>
</div>
