<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конструктор</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/constructor-page.css'])
    @vite(['resources/css/footer.css'])
</head>

<body class="m-0 bg-[#2C3E50]">
    @include('page-elements.header')

    <div class="constructor-section">
        <h1 class="constructor-title">Выберите категорию товара</h1>

        <div class="categories-container">
            @foreach($categories as $category)
                <div class="category-card">
                    <a href="{{ route('constructor.templates', $category->id) }}">
                        <div class="category-image">
                            <img src="{{ asset('img/categories/' . $category->image) }}" alt="{{ $category->name }}">
                        </div>
                        <h2 class="category-name">{{ $category->name }}</h2>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    @include('page-elements.footer')

</body>

</html>
