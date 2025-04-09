<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конструктор</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Выберите шаблон для заказа</h1>

        <ul>
            @foreach($templates as $template)
                <li>
                    <h3>{{ $template->name }}</h3>
                    <p>{{ $template->description }}</p>
                    <a href="{{ route('constructor.create', $template->id) }}">Создать заказ</a>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
