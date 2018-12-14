<!doctype html>
<html lang="en">

<head>
    @include('shared.head')
</head>

<body class="text-center d-flex align-items-center justify-content-center py-4">
    <form class="form-signin w-100 p-1 my-0 mx-auto">
        <img class="mb-4" src="{{ URL::asset('/logo.jpg') }}" alt="" width="306" height="126">
        <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.welcome1', ['appname' => config('app.name')]) }}</h1>
        <h1 class="h3 mb-3 font-weight-normal">{{ __('auth.welcome2') }}</h1>
        <label for="inputEmail" class="sr-only">{{ __('fields.email') }}</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="{{ __('fields.email') }}" required autofocus>
        <label for="inputPassword" class="sr-only">{{ __('fields.password') }}</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="{{ __('fields.password') }}" required>
        <div class="checkbox mb-3">
            <label>
          <input type="checkbox" value="remember-me"> {{ __('fields.remember_me')}}
        </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('actions.login') }}</button>
    </form>
</body>

</html>