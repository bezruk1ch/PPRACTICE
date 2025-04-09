<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Шаблоны - Конструктор</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/constructor-page.css'])
    @vite(['resources/css/footer.css'])
</head>

<body class="m-0 bg-[#2C3E50]">
    @include('page-elements.header')

    <div class="constructor-templates">
        <h1 class="templates-title">Шаблоны для категории: {{ $category->name }}</h1>

        <div class="templates-grid">
            @foreach ($templates as $template)
            <div class="template-card">
                <img src="{{ asset('img/categories/' . $template->image) }}" class="template-image" alt="Template Image">
                <div class="template-body">
                    <h5 class="template-name">{{ $template->name }}</h5>
                    <p class="template-description">{{ $template->description }}</p>
                    <a href="{{ route('constructor.edit', ['template' => $template->id]) }}" class="template-edit-btn">Редактировать</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('page-elements.footer')

</body>

</html>
