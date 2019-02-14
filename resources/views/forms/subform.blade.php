<div class="form-group row">
    <label class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        <div class="jumbotron my-1 py-2">
            @foreach($fields as $data)
            @php
            if(array_key_exists('valueField', $data)){
            $data['value'] = $value->{$data['valueField']} ?? "";
            }
            @endphp
            @include('forms.'.$data['type'], $data)
            @endforeach
        </div>
    </div>
</div>