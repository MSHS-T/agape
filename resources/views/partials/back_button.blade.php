@php($url = $url ?? url()->previous())
<div class="row">
    <div class="col-12 text-center">
        <a href="{{ $url }}" class="btn btn-secondary">{{ __('actions.back') }}</a>
    </div>
</div>
