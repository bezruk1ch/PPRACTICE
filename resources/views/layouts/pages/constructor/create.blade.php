<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конструктор заказа</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Создание заказа для шаблона: {{ $template->name }}</h1>

        <!-- Сообщение об успехе -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Форма для создания заказа -->
        <form action="{{ route('constructor.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="template_id" value="{{ $template->id }}">

            <div>
                <label for="title">Заголовок</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div>
                <label for="description">Описание</label>
                <textarea name="description" id="description" rows="4"></textarea>
            </div>

            <div>
                <label for="image">Изображение</label>
                <input type="file" name="image" id="image">
            </div>

            <div>
                <button type="submit">Создать заказ</button>
            </div>
        </form>
    </div>
</body>
</html>
