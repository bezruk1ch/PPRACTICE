<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/constructor-page.css'])
    @vite(['resources/css/footer.css'])
    <title>Редактор дизайна</title>

</head>

<body class="constructor-page">
    @include('page-elements.header')

    <main class="constructor-container">
        <div class="editor-wrapper">
            <!-- Основное поле редактора -->
            <div class="editor-canvas-container">
                <div id="design-editor" data-template="{{ json_encode($template) }}"></div>
            </div>

            <!-- Панель инструментов -->
            <div class="editor-tools-panel">
                <h2 class="tools-title">Инструменты</h2>

                <!-- Текстовый инструмент -->
                <div class="tool-group">
                    <label class="tool-label">Текст</label>
                    <textarea id="text-input" class="tool-input"></textarea>
                    <button id="add-text" class="tool-button">Добавить текст</button>
                </div>

                <!-- Инструмент изображений -->
                <div class="tool-group">
                    <label class="tool-label">Изображение</label>
                    <input type="file" id="image-upload" class="tool-input">
                    <button id="add-image" class="tool-button">Добавить изображение</button>
                </div>

                <!-- Кнопка сохранения -->
                <button id="save-design" class="save-button">Сохранить макет</button>
            </div>
        </div>
    </main>

    @include('page-elements.footer')

    @vite(['resources/js/constructor-editor.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.1/fabric.min.js"></script>
</body>

</html>