<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Главная страница</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/header.css',
    'resources/css/slider.css',
    'resources/css/portfolio-main.css',
    'resources/css/constructor-main.css',
    'resources/css/review-main.css',
    'resources/css/contacts-main.css',
    'resources/css/footer.css'
    ])
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    <div class="page-wrapper"><!-- FLEX‑обёртка -->

        @include('page-elements.header')

        <!-- Основной контент -->
        <div class="page-content">
            @include('page-elements.slide')
            @include('page-elements.constructor')
            @include('page-elements.portfolio')
            @include('page-elements.reviews')
            @include('page-elements.contacts-main')
        </div>

        @include('page-elements.footer')
    </div>

    <!-- ===== Модальные окна ===== -->
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

    @foreach ($portfolios as $portfolio)
    <div id="modal-{{ $portfolio->id }}" class="portfolio-modal hidden">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal({{ $portfolio->id }})">&times;</span>
            <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}" class="modal-image" />
            <h3>{!! nl2br(e($portfolio->title)) !!}</h3>
            <p class="modal-description">{{ $portfolio->description }}</p>
            <p class="modal-tags">{{ $portfolio->tags }}</p>
        </div>
    </div>
    @endforeach

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.portfolio-modal').forEach(modal => {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });
    </script>
</body>

</html>