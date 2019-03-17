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
            <option value="new">{{ __('fields.other') }}</option>
        </select>
        @if(isset($help))
        <small id="{{$id}}HelpBlock" class="form-text text-muted">
            {!! $help !!}
        </small>
        @endif
        <div class="jumbotron mt-1 py-1 collapse {{ $value != 'none' ? 'show' : '' }}">
            @foreach($fields as $data)
            @php
            if(array_key_exists('valueField', $data)){
            $data['value'] = '';
            }
            @endphp
            @include('forms.'.$data['type'], $data)
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('select#{{$id}}').change(function (e) {
            var fields = @json($fields);
            var selectionId = $(this).val();
            if (selectionId == "new" || selectionId == "none") {
                _.each(fields, function (field) {
                    var fieldId = "#input" + _.upperFirst(_.camelCase(field.name));
                    $(fieldId).val("");
                    $(fieldId).attr('readonly', false);
                });
            } else {
                var value = _.find(@json($allowedValues), function (i) {
                    return i.id == _.toSafeInteger(selectionId);
                });
                _.each(fields, function (field) {
                    var fieldId = "#input" + _.upperFirst(_.camelCase(field.name));
                    if(field.hasOwnProperty("valueField")){
                        $(fieldId).val(value[field.valueField]);
                        $(fieldId).attr('readonly', true);
                    } else {
                        console.log(field);
                        $(fieldId).val(field.value);
                    }
                });
            }
            if (selectionId == "none") {
                $(this).next('.jumbotron').collapse('hide');
            } else {
                $(this).next('.jumbotron:not(.show)').collapse('show');
            }
        })
        var value = '{{$value}}';
        if (value !== "") {
            $('select#{{$id}}').val(value);
            $('select#{{$id}}').change();
        }
    });

</script>
@endpush
