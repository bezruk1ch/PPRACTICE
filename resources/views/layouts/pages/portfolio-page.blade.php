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
    @vite(['resources/css/slider.css'])
    @vite(['resources/css/portfolio-main.css'])
    @vite(['resources/css/constructor-main.css'])
    @vite(['resources/css/review-main.css'])
    @vite(['resources/css/contacts-main.css'])
    @vite(['resources/css/footer.css'])
    <title>Главная страница</title>
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    @include('page-elements.header')

    <section class="portfolio-section">
        <div class="container-portfolio">
            <!-- Заголовок -->
            <h2 class="portfolio-title">Примеры наших работ</h2>

            <!-- Описание -->
            <p class="portfolio-description">
                Посмотрите примеры наших работ и вдохновитесь<br>идеями для своего проекта!
            </p>

            <!-- Секция с работами -->
            <div class="portfolio-items">
                @foreach ($portfolios as $portfolio)
                <div class="portfolio-item">
                    <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}" class="portfolio-image">
                    <p class="portfolio-text">{!! nl2br(e($portfolio->title)) !!}</p>
                </div>
                @endforeach
            </div>

            <!-- Кнопки для прокрутки -->
            <div class="reviews-navigation">
                <button class="prev-btn" onclick="scrollReviews(-1)">Назад</button>
                <button class="next-btn" onclick="scrollReviews(1)">Вперед</button>
            </div>
        </div>
    </section>

    @include('page-elements.footer')
</body>

</html>