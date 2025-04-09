<div class="reviews-section">
    <div class="reviews-container">
        <!-- Заголовки -->
        <h2 class="reviews-main-title">Отзывы наших клиентов</h2>
        <p class="reviews-subtitle">Узнайте, что говорят о нас наши клиенты</p>

        <!-- Контейнер для карточек -->
        <div class="reviews-grid">
            @foreach ($reviews as $review)
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

                    <!-- Блок с именем, рейтингом и датой -->
                    <div class="review-info">
                        <div class="name-and-rating">
                            <h3 class="review-name">
                                @if($review->is_company)
                                <span>Типография «А Плюс»
                                    @else
                                    <span class="first-name">{{ $review->user_name }}</span>
                                    <span class="last-name">{{ $review->user_surname }}</span>
                                    @endif
                            </h3>

                            <!-- Звезды рейтинга -->
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

                        <!-- Дата -->
                        <p class="review-date">
                            @if($review->is_company)
                            <span class="company-date">Работаем с 2013 года </span>
                            @else
                            {{ $review->created_at->format('d.m.Y') }}
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Текст отзыва -->
                <div class="review-content">
                    @if($review->is_company)
                    <!-- Специальное сообщение компании -->
                    <div class="text-wrapper">
                        <p class="review-text">
                            Средняя оценка наших клиентов: 4.9 из 5<br>
                            Нам доверяют более 1000 клиентов!
                        </p>
                    </div>
                    <a href="{{ route('profile') . '#leave-review-section' }}" class="leave-review-btn">
                        Оставить отзыв
                    </a>
                    @else
                    <!-- Обычный отзыв -->
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

        <!-- Кнопка "Смотреть все отзывы" -->
        <div class="all-reviews-btn-container">
            <button class="all-reviews-btn" onclick="location.href='/reviews'">
                Смотреть все отзывы
            </button>
        </div>
    </div>
</div>