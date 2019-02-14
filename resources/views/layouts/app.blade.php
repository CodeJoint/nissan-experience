<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nissan Oculus') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/third.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo-brand" src="{{ asset('images/nissan-logo.png') }}" alt="{{ config('app.name', 'Nissan Oculus Experience') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if( Auth::user()->role === 'superadmin')
                                        <a class="dropdown-item" href="{{ route('register') }}" >
                                            Registro
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Salir
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

        <main class="">
            @yield('content')
        </main>
    </div>

</body>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" ></script>

<script type="text/javascript">
    $(function () {
        var moment = window.moment;
        setTimeout( function () {
            $('#datetimepicker_start').datetimepicker({
                locale: 'es',
                format: 'YYYY/MM/DD',
                allowInputToggle: true,
                defaultDate: $('#datetimepicker_start').val() ? $('#datetimepicker_start').val() : moment().format('Y-MM-DD')
            });
            $('#datetimepicker_end').datetimepicker({
                locale: 'es',
                format: 'YYYY/MM/DD',
                allowInputToggle: true,
                defaultDate: $('#datetimepicker_end').val() ? $('#datetimepicker_end').val() : moment().format('Y-MM-DD')
            });
            $('#generateReport').click(function () {
                window.open('report?store='+ $('#storeSelect').val()+'&from='+ $('#datetimepicker_start').val()+'&to='+ $('#datetimepicker_end').val(), '_blank');
            });
        }, 1200)
    });
</script>
</html>
