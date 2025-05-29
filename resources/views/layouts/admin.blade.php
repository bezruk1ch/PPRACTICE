<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/admin.css'])
</head>

<body>
    <header>
        <h1>Админ-панель</h1>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Главная</a>
            <a href="{{ route('admin.orders') }}">Заказы</a>
            <a href="{{ route('admin.users.index') }}">Пользователи</a>
            <a href="{{ route('admin.reviews.index') }}">Отзывы</a>
            <a href="{{ route('admin.feedbacks.index') }}">Все заявки</a>
            {{-- Добавь больше ссылок по мере надобности --}}
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Выход</button>
            </form>
        </nav>
    </header>

    <main>
        {{-- сюда будем “втыкать” контент из дочерних шаблонов --}}
        @yield('content')
    </main>
</body>

</html>