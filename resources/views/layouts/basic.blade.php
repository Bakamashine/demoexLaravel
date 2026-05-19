<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <link rel="stylesheet" href="{{asset("/css/bootstrap.min.css")}}">
    <title>@yield("title") : {{env("APP_NAME")}}</title>

</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">{{ env("APP_NAME") }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{route("about")}}">О нас</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{route("login")}}">Авторизация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route("register")}}">Регистрация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route("admin.login")}}">Вход для администратора</a>
                        </li>
                    @endguest

                    @auth
                        @if(Auth::user()->role === \App\Enum\UserRole::Admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route("admin.index")}}">Админ-панель</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{route("account")}}">Личный кабинет</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form method="post" action="{{route('logout')}}">
                                @csrf
                                <button class="nav-link">Выход</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
    @yield("content")
</main>

<script src="{{asset("/js/bootstrap.min.js")}}"></script>
</body>
</html>

