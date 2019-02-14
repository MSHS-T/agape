@php
$id = 'input'.ucfirst(camel_case($name));
$money = false;
if(($type ?? 'text') == "money"){
$type = "number";
$step = 0.01;
$money = true;
}
if(empty($value)){
    $value = [null];
}
@endphp
<div class="form-group row">
    <label class="col-3 col-form-label">{{$label}}</label>
    <div class="col-9 multipleinput" id="multi_{{$id}}">
        @foreach($value as $idx => $v)
        <div class="row mb-1">
            <div class="col">
                @if($money || $loop->last)
                    <div class="input-group">
                        @endif
                        <input type="{{ $input['type'] ?? 'text' }}" class="form-control" id="{{$id}}_{{$idx+1}}" name="{{$name}}_{{$idx+1}}" placeholder="{{$label}}"
                            value="{{$v}}" @if (isset($step)) step="{{ $step }}" @endif>
                        @if($money || $loop->last)
                        <div class="input-group-append">
                            @if($money)
                                <span class="input-group-text">{{ __('locale.currency') }}</span>
                            @endif
                            @if ($loop->last)
                                <button type="button" class="btn btn-outline-secondary add-button">
                                    {{ __('actions.add') }}
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endforeach

        @if(isset($help))
        <small id="{{$id}}HelpBlock" class="form-text text-muted">
            {!! $help !!}
        </small>
        @endif
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#multi_{{$id}} button.add-button").on('click', function(e){
            e.preventDefault();
            var container = $("#multi_{{$id}}"),
                lastRow = container.children(".row:last-child")
                newRow = lastRow.clone(true),
                newInput = newRow.find('input');

            newInput.val('');

            $.each(['id', 'name'], function(i, attribute){
                newInput.attr(attribute, newInput.attr(attribute).replace(/(\d+)$/g, function(match, number) {
                    return parseInt(number)+1;
                }));
            })
            newRow.appendTo(container);
            lastRow.find('button.add-button').remove();
            if(container.children(".row").length >= {{$maximum_count}}){
                container.find('button.add-button').remove();
            }
            return false;
        })
    });

</script>
@endpush
