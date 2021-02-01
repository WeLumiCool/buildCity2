<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Админка') }}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">--}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css">--}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')

</head>

<body style="background: #ffffff">


<div id="app">
    <div id="loader"></div>
    <header class="container-fluid bg-white shadow-sm px-0">
        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo2.png') }}" class="logo" alt="" style="width:96px; height:auto;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item text d-none">
                            <a href="{{ route('admin.desks.replace') }}"
                               class="nav-link {{ request()->is('admin/replace*') ? 'active' : '' }}">
                                {{ __('Поменять пользователя') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                                {{ __('Пользователи') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.activated.index') }}"
                               class="nav-link {{ request()->is('admin/activate*') ? 'active' : '' }}">
                                {{ __('Активные стола') }}</a>
                        </li>
                        <li class="nav-item mr-5">
                            <a href="{{ route('admin.desks.index') }}"
                               class="nav-link  {{ request()->is('admin/desk*') ? 'active' : '' }}">
                                {{ __('Неактивные стола') }}</a>
                        </li>
                        <li class="nav-item d-flex" style="color: #7f7f7f">
                            <p class="pt-2">Баланс:&nbsp;</p>
                            <p class="pt-2">{{ Auth::user()->balance }} $</p>
                        </li>

                    </ul>
                    <ul class="navbar-nav">
                        @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   if(confirm('вы действительно хотите выйти?')){
                                       document.getElementById('logout-form').submit();
                                   }" style="margin: 0px 5px;">
                                    {{ __('Выход') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    @yield('content')
</div>


{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/js/mdb.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    var preloader = document.getElementById('loader');
    function preLoaderHandler(){
        preloader.style.display = 'none';
    }
</script>
@stack('scripts')
</body>
</html>
