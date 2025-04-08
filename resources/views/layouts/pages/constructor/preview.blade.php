<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Предпросмотр дизайна</title>

    <!-- Оптимизированное подключение шрифтов -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Подключение стилей через Vite -->
    @vite([
    'resources/css/app.css',
    'resources/css/header.css',
    'resources/css/constructor-page.css',
    'resources/css/footer.css'
    ])
</head>

<body class="preview-page">
    @include('page-elements.header')

    <main class="preview-container">
        <div class="preview-content">
            <h1 class="preview-title">Предпросмотр вашего дизайна</h1>

            <div class="design-preview">
                <img src="{{ asset('storage/' . $design->preview_image) }}"
                    alt="Предпросмотр дизайна"
                    class="preview-image"
                    onerror="this.src='{{ asset('img/header/logo.png') }}'">
            </div>

            <div class="preview-actions">
                <a href="{{ route('constructor.index') }}" class="action-button back-button">
                    Вернуться к редактированию
                </a>

                <form action="{{ route('constructor.print', $design->id) }}" method="POST" class="print-form">
                    @csrf
                    <button type="submit" class="action-button print-button">
                        Отправить в печать
                    </button>
                </form>
            </div>
        </div>
    </main>

    @include('page-elements.footer')

    @vite(['resources/js/app.js'])
</body>

</html>