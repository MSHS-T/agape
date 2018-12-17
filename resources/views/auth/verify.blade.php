@extends('layouts.app')

@section('content')
@if (session('resent'))
<div class="alert alert-success" role="alert">
    {{ __('auth.resent_verification') }}
</div>
@endif
<div class="container">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <h1 class="mb-3">{{ __('actions.registered') }}</h1>
                <h3>
                    {{ __('auth.need_email_verification')}}<br />
                    <small class="text-muted">
                        {{ __('auth.need_email_verification2')}}
                        <a href="{{ route('verification.resend') }}">{{ __('auth.need_email_verification3')}}</a>.
                    </small>
                </h3>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
