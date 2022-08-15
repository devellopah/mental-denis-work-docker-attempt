<!doctype html>
<html class="no-js" lang="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="">
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="theme-color" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="manifest" href="site.webmanifest">

    <link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="">
    <link rel="apple-touch-icon" sizes="72x72" href="">
    <link rel="apple-touch-icon" sizes="114x114" href="">
    <link rel="apple-touch-icon" sizes="120x120" href="">
    <link rel="apple-touch-icon" sizes="144x144" href="">
    <link rel="apple-touch-icon" sizes="152x152" href="">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>

    @component('components.header_scripts')
    @endcomponent

</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">Вы используете <strong>устаревшую</strong> версию браузера. Пожалуйста, <a href="https://browsehappy.com/">обновите ваш браузер</a>.</p>
<![endif]-->
<header class="header">
    <a href="/" title="" class="logo">
        <img src="/img/logo.svg" alt="">
    </a>
    <a class="burger" href="#">
        <button class="hamburger" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
        </button>
    </a>
    <a href="#" class="user-mob">
        <img src="/img/man5.jpg" alt="">
    </a>
    <!--/ для страниц аккаунта>
    <a href="#" class="user-mob user-mob--brd">
      <img src="../img/man5.jpg" alt="">
    </a>
    <!-->
</header>

<main class="pdg groups" id="app">
    @if(Auth::check())
        <nav class="nav">
            <div class="nav__in">
                <ul>
                    @foreach(\Auth::user()->getUserMenu() as $item)
                        <li class="nav__item">
                            <a href="{{ $item['route'] }}" class="nav__link {{ Request::route()->getName() == $item['name'] ? 'nav__link--active' : ''}}" title="">
                                <span class="btn-green {{ $item['class'] }}"><span></span></span>
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="nav__toggle">
                <a href="#" class="nav__link js-nav-toggle" title="">
                    <span class="btn-green icon-arrow"><span></span></span>
                    Свернуть
                </a>
            </div>
        </nav>

        <aside class="panel">
            <div class="panel__top">
                <a href="{{ route('user.profile') }}" title="Профиль" class="user">
                    <img src="/images/avatars/{{ Auth::user()->avatar }}" alt="">
                </a>
            </div>
            <div class="panel__icon">
                <a href="{{ route('user.profile') }}" title="Профиль" class="btn-blue icon-credit"><span></span></a>
            </div>
            @if(\Auth::user()['rang'] == config('rang.admin'))
                <div class="panel__icon">
                    <a href="{{ url('/generator') }}" title="Генератор" class="btn-blue icon-settings"><span></span></a>
                </div>
            @endif
            @if(\Auth::user()->rang === config('rang.admin'))
                <div class="panel__icon">
                    <a href="{{ url('/user/create') }}" title="Добавить пользователя" class="btn-blue icon-plus"><span></span></a>
                </div>
            @endif
            <div class="panel__bt">
                <a href="{{ url('/logout') }}" title="Выйти" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn-blue icon-power"><span></span></a>
            </div>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        </aside>

    @endif

    @yield('content')


    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Подтвердите действие</b></h4>
                </div>
                <div class="modal-body">
                    <p>
                        <b>
                            Вы уверены что хотите удалить данный элемент?
                        </b>
                    </p>
                </div>
                <div class="modal-footer">
                    <form id="deleteModalForm" action="" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="button" class="btn btn-raised btn-danger" data-dismiss="modal">Отмена</button>
                        <button class="btn btn-raised btn-danger"> Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


    <script src="{{ asset('js/libs/libs.js') }}"></script>
<script src="{{ asset('js/libs/scroll.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
