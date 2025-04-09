<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конструктор шаблона - Конструктор</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/header.css', 'resources/css/constructor-page.css', 'resources/css/footer.css'])
</head>

<body class="m-0 bg-[#2C3E50]">
    @include('page-elements.header')

    <div class="container edit-page-container">
        <h1 class="text-center mb-4">Конструктор шаблона</h1>

        <!-- Отображение ошибок формы -->
        @if ($errors->any())
            <div class="alert alert-danger edit-page-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('constructor.save', ['template' => $template->id]) }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf

            <!-- Изменить текст -->
            <div class="mb-3">
                <label for="text" class="form-label">Изменить текст</label>
                <textarea name="text" class="form-control edit-textarea" id="text" rows="4">{{ old('text', $template->text) }}</textarea>
            </div>

            <!-- Заменить изображение -->
            <div class="mb-3">
                <label for="logo" class="form-label">Заменить логотип</label>
                <input type="file" name="logo" class="form-control edit-file-input" id="logo">
            </div>

            <!-- Выбрать шрифт -->
            <div class="mb-3">
                <label for="font" class="form-label">Выберите шрифт</label>
                <select name="font" class="form-select edit-font-select" id="font">
                    <option value="Arial" {{ $template->font == 'Arial' ? 'selected' : '' }}>Arial</option>
                    <option value="Verdana" {{ $template->font == 'Verdana' ? 'selected' : '' }}>Verdana</option>
                    <option value="Times New Roman" {{ $template->font == 'Times New Roman' ? 'selected' : '' }}>Times New Roman</option>
                </select>
            </div>

            <!-- Изменить цвет фона -->
            <div class="mb-3">
                <label for="background_color" class="form-label">Выберите цвет фона</label>
                <input type="color" name="background_color" class="form-control edit-color-input" id="background_color" value="{{ old('background_color', $template->background_color) }}">
            </div>

            <!-- Кнопка сохранить -->
            <button type="submit" class="btn btn-primary edit-submit-btn">Сохранить изменения</button>
        </form>

        <hr>

        <!-- Покажем предварительный просмотр шаблона -->
        <div class="template-preview mt-4">
            <h2 class="text-center">{{ $template->name }}</h2>
            <div class="template-container" style="background-color: {{ $template->background_color ?? '#FFFFFF' }};">
                <img src="{{ asset('images/' . $template->image) }}" alt="Logo" class="template-logo" />
                <p class="template-text" style="font-family: '{{ $template->font }}';">{{ $template->text }}</p>
            </div>
        </div>

    </div>

    @include('page-elements.footer')


</body>

</html>
