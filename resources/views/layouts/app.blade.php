<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BuildCity</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/treeflex/dist/css/treeflex.css">
    @stack('styles')
</head>
<body>
<div id="app">
    <header class="container-fluid bg-white shadow-sm px-0">
        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo2.png') }}" alt="" style="width:96px; height:auto;">
                </a>

                <a class="d-lg-none d-block" href="{{ route('login') }}">
                    <button class="btn text-white" style="background: #dfcaa4"><i class="fas fa-user mr-2"></i>Войти</button>
                </a>
                @if(Auth::check())
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                @endif
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <!-- Authentication Links -->
                        @if(Auth::check())
                            @if(Auth::user()->is_active)
                                @if(Auth::user()->role)
                                    <li class="nav-item mr-3">
                                        <a class="nav-link text-dark"
                                           href="{{ route('admin.desks.index') }}">{{ __('Админ. панель') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item mr-3">
                                    <a class="nav-link text-dark"
                                       href="{{ route('cabinet') }}">{{ __('Личный кабинет') }}</a>
                                </li>
                            @endif
{{--                            @if(Auth::user()->is_active)--}}
{{--                                <li class="nav-item d-flex" style="color: #7f7f7f">--}}
{{--                                    <p class="pt-2">Баланс:&nbsp;</p>--}}
{{--                                    <p class="pt-2">{{ Auth::user()->balance }} $</p>--}}
{{--                                </li>--}}
{{--                            @endif--}}


                        @endif
                    </ul>
                    @if(Auth::check())
                    <ul class="navbar-nav">
                        <li class="nav-item mr-3 pb-2">
                            <a class="nav-link text-dark" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     if(confirm('вы действительно хотите выйти?')){
                                       document.getElementById('logout-form').submit();
                                   }">
                                {{ __('Выход') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    @elseif(!str_contains(url()->current(), '/login'))
                        <a href="{{ route('login') }}">
                            <button class="btn text-white" style="background: #dfcaa4"><i class="fas fa-user mr-2"></i>Войти</button>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </header>


    <main class="pt-5">
        @yield('content')
    </main>
    @include('layouts.footer')
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/masked-input.js') }}"></script>
@stack('scripts')
</body>
</html>
