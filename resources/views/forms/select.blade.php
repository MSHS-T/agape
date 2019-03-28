@php
    $id = 'input'.ucfirst(camel_case($name));
    if($multiple) {
        $name = $name."[]";
    }
    else {
        $maximum_count = 1;
    }
    $placeholder = $multiple ? __('actions.select_elements') : __('actions.select_element');
    $value = is_array($value ?? null) ? $value : [($value ?? null)];
@endphp
<div class="form-group row">
    <label for="{{$id}}" class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9">
        <div class="row">
            <div class="col">
                <select class="form-control chosen-select" id="{{$id}}" name="{{$name}}" @if($multiple) multiple @endif data-placeholder="{{ $placeholder }}">
                    @foreach($allowedValues as $v)
                        @php
                            $valueVal = $v->{$valueField};
                            $displayVal = $v->{$displayField};
                        @endphp
                        <option value="{{ $valueVal }}" @if(in_array($valueVal, $value)) selected @endif>{{ $displayVal }}</option>
                    @endforeach
                </select>
                @if(isset($help))
                    <small id="{{$id}}HelpBlock" class="form-text text-muted">
                        {!! $help !!}
                    </small>
                @endif
            </div>
        </div>
        @if($allowNew)
            <div class="row">
                <label for="{{$id}}_addField" class="col-3 col-form-label">
                    {{ __('actions.add_element') }}
                </label>
                <div class="col-9">
                    <div class="input-group">
                        <input type="text" class="form-control" id="{{$id}}_addField">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" id="{{$id}}_addButton">
                                {{ __('actions.add') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#{{$id}}").chosen({
                max_selected_options: {{$maximum_count}},
                no_results_text: "{{ __('datatable.zeroRecords') }} : "
            });
            @if($allowNew)
                $("#{{$id}}_addButton").on('click', function(){
                    if($('#{{$id}}').children('option:selected').length >= {{$maximum_count}}){
                        return false;
                    }
                    var newEntry = $('#{{$id}}_addField').val();
                    $('#{{$id}}_addField').val("");
                    $('#{{$id}}').append($('<option value="'+newEntry+'" selected>'+newEntry+'</option>'));
                    $("#{{$id}}").trigger('chosen:updated');
                })
            @endif
        });
    </script>
@endpush
