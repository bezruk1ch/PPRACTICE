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

        <!-- Кнопка "Смотреть все работы" -->
        <div class="portfolio-button-container">
            <button class="portfolio-button">Смотреть все работы</button>
        </div>
    </div>
</section>