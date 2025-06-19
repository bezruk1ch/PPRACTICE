<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/review-main.css'])
    @vite(['resources/css/footer.css'])
    <title>Все отзывы</title>
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    <div class="page-wrapper">

        @include('page-elements.header')

        <div class="page-content">

            <div class="reviews-section">
                <div class="reviews-container">
                    <!-- Заголовки -->
                    <h2 class="reviews-main-title">Отзывы наших клиентов</h2>
                    <p class="reviews-subtitle">Узнайте, что говорят о нас наши клиенты</p>

                    <!-- Контейнер для прокручиваемых отзывов -->
                    <div class="reviews-grid-container">
                        <div class="reviews-grid">
                            @foreach ($reviews->take(4) as $review) <!-- Ограничиваем 4 отзыва -->
                            <div class="review-card {{ $review->is_company ? 'company-card' : '' }}">
                                <div class="review-header">
                                    <!-- Аватар/Логотип -->
                                    @if($review->is_company)
                                    <img src="{{ asset('img/reviews/logo.png') }}" alt="Логотип компании" class="review-avatar company-logo">
                                    @else
                                    <img src="{{ $review->user_avatar ?? asset('img/default-avatar.png') }}"
                                        alt="{{ $review->user_name }} {{ $review->user_surname }}"
                                        class="review-avatar">
                                    @endif

                                    <div class="review-info">
                                        <div class="name-and-rating">
                                            <h3 class="review-name">
                                                @if($review->is_company)
                                                <span>Типография «А Плюс»</span>
                                                @else
                                                <span class="first-name">{{ $review->user_name }}</span>
                                                <span class="last-name">{{ $review->user_surname }}</span>
                                                @endif
                                            </h3>
                                            <div class="rating-stars">
                                                @if($review->is_company)
                                                <div class="company-rating">Наш рейтинг: 4.9</div>
                                                @else
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                                    @endfor
                                                    @endif
                                            </div>
                                        </div>
                                        <p class="review-date">
                                            @if($review->is_company)
                                            <span class="company-date">Работаем с 2013 года</span>
                                            @else
                                            {{ $review->created_at->format('d.m.Y') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="review-content">
                                    @if($review->is_company)
                                    <div class="text-wrapper">
                                        <p class="review-text">
                                            Средняя оценка наших клиентов: 4.9 из 5<br>
                                            Нам доверяют более 1000 клиентов!
                                        </p>
                                    </div>
                                    <a href="/leave-review" class="leave-review-btn">
                                        Оставить отзыв
                                    </a>
                                    @else
                                    <div class="text-wrapper">
                                        <p class="review-text {{ mb_strlen($review->comment) > 164 ? 'short' : '' }}">
                                            {{ $review->comment }}
                                        </p>
                                        @if(mb_strlen($review->comment) > 164)
                                        <button class="read-more-btn"
                                            data-review="{{ json_encode([
                                        'avatar' => $review->user_avatar ?? 'default-avatar.png',
                                        'name' => $review->user_name,
                                        'surname' => $review->user_surname,
                                        'text' => $review->comment,
                                        'rating' => $review->rating,
                                        'date' => $review->created_at->format('d.m.Y')
                                    ]) }}">
                                            Читать полностью...
                                        </button>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Кнопки для прокрутки -->
                    <div class="reviews-navigation">
                        <button class="prev-btn" onclick="scrollReviews(-1)">Назад</button>
                        <button class="next-btn" onclick="scrollReviews(1)">Вперед</button>
                    </div>
                </div>
            </div>

        </div>


        @include('page-elements.footer')

    </div>

    <!-- Модальное окно -->
    <div class="review-modal" id="reviewModal">
        <div class="review-modal-content">
            <span class="review-modal-close" id="reviewModalClose">&times;</span>
            <div class="review-modal-body">
                <div class="review-modal-avatar-rating">
                    <img src="" alt="Аватар" class="review-modal-avatar" />
                    <div>
                        <div class="review-modal-name" id="reviewModalName"></div>
                        <div class="review-modal-date" id="reviewModalDate"></div>
                        <div class="review-modal-stars" id="reviewModalStars"></div>
                    </div>
                </div>
                <p class="review-modal-text" id="reviewModalText"></p>
            </div>
        </div>
    </div>

</body>

</html>