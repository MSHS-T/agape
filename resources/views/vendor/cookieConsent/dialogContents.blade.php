<div class="fixed-bottom pb-4 pr-4">
    <div class="js-cookie-consent cookie-consent float-right alert alert-warning border shadow fade show" role="alert">
        <span class="cookie-consent__message">
            {!! trans('cookieConsent::texts.message') !!}
        </span>
        <button type="button" class="btn btn-primary btn-sm ml-1 js-cookie-consent-agree cookie-consent__agree">
            {{ trans('cookieConsent::texts.agree') }}
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="alert">
            {{ trans('cookieConsent::texts.disagree') }}
        </button>
    </div>

</div>