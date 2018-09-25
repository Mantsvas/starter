<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">
    <title>{{ config('app.name', 'Lietuva N18') }}</title>




    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Google Analytics -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122999790-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-122999790-1');
    </script> -->

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/clashRo.css') }}" rel="stylesheet">


</head>
<body class="p-0">
    <div id="app">
        <header class="bg-dark">
            <div class="row">
                <div class="col-4">

                    <a class="navbar-brand mt-3" href="{{ url('/') }}">
                        <img class="logo" src="{{asset('img/svg/LietuvaN18Logo.svg')}}" alt="">
                    </a>
                </div>
                <div class="col-8">

                    <div class="row ">
                        <div class="col-12 col-sm-6 offset-sm-5 pt-3">
                            <div class="text-center float-right mb-5 mt-2 mx-2">
                                <form class="form-inline" action="{{route('players.store')}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <select class="form-control d-none d-md-inline" name="">
                                            <option value="">Player</option>
                                        </select>
                                        <input id="royale_id" type="text" class="form-control{{ $errors->has('royale_id') ? ' is-invalid' : '' }}" name="royale_id" value="{{old('royale_id')}}" placeholder="Tag: #XXXXX" autofocus>
                                        <span class="input-group-btn">
                                            <button class="btn" type="submit" name="button"><i class="fas fa-search"></i></button>
                                        </span>

                                        @if ($errors->has('royale_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('royale_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav  class="navbar navbar-expand-md navbar-dark navbar-laravel bg-dark">
                <div class="container">
                        <div class="">

                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                            </ul>
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('posts.index') }}">{{ __('Deck Guides') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('players.index') }}">{{ __('Lietuva N18') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('wars.index') }}">{{ __('Clan Wars') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('tournaments.index') }}">Tournaments</a>
                                </li>

                                <!-- Authentication Links -->
                                @guest
                                    <li><a href="{{url('auth/google')}}" class='loginBtn loginBtn--google'>Google Login</a></li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li> -->
                                @else

                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                @if(Auth::user()->admin === 1)
                                                    <a class="dropdown-item" href="{{ route('players.create') }}">
                                                        {{ __('New Player') }}
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('wars.create') }}">
                                                        {{ __('New War') }}
                                                    </a>
                                                @endif
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
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
        </header>
        <main class="p-4">
                    @yield('content')
        </main>
        <footer class="">
            <img src="/img/footer.jpg" alt="">
        </footer>
    </div>
</body>
</html>
