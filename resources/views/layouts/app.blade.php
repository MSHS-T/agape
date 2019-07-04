@extends('layouts.master')
@section('head_content')
<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')
@endsection
@section('body')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-laravel"> {{-- Dark nav theme : navbar-dark bg-dark --}}
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ URL::asset('/logo_ligne.png') }}" alt="{{ config('app.name') }}" height="39">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('actions.toggle_navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest @else
                        <a class="nav-link" href="{{route('home')}}">{{__('actions.home')}}</a>
                        @switch(Auth::user()->role)
                        @case(\App\Enums\UserRole::Admin)
                        <a class="nav-link" href="{{route('projectcall.index')}}">{{__('actions.projectcall.list')}}</a>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('actions.administration') }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('studyfield.index') }}">
                                    {{ __('actions.study_fields') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('laboratory.index') }}">
                                    {{ __('actions.laboratories') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.index') }}">
                                    {{ __('actions.user.list') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    {{ __('actions.settings.list') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('globalExport') }}">
                                    {{ __('actions.globalExport') }}
                                </a>
                            </div>
                        </li>
                        @break
                        @case(\App\Enums\UserRole::Expert)
                        @endswitch
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('actions.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('actions.register') }}</a>
                        </li>
                        @endif @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">{{ __('actions.profile') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('actions.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alter-dismissible fade show alert-danger" role="alert">
                                    <u>{{ __('fields.error') }}</u> : {{ $error }}
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="{{ __('actions.close') }}"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <br />
                            @endforeach
                        @endif
                        @if(session()->get('success'))
                            <div class="alert alter-dismissible fade show alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <br />
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <span class="text-muted">
                &copy; {{ config('app.name') }} 2018-{{ date('Y') }} - <a href="{{ route('contact') }}">{{ __('actions.contact') }}</a> - <a href="{{ route('legal') }}">{{ __('actions.legal') }}</a>
                <br/>
                {!! __('actions.credits') !!}
            </span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
@endsection('body')