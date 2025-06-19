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
    @vite(['resources/css/review-main.css'])
    @vite(['resources/css/contacts-main.css'])
    @vite(['resources/css/footer.css'])
    <title>Главная страница</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="m-0 bg-[#2C3E50] font-montserrat">
    <div class="page-wrapper">

        @include('page-elements.header')

        <div class="page-content">

            <section class="contacts-section">
                <h2 class="contacts-title">Контакты</h2>
                <p class="contacts-subtitle">Свяжитесь с нами или посетите наш офис</p>

                <div class="contacts-container">
                    <div class="contacts-info">
                        <p>ООО "А плюс"</p>

                        <p class="contact-item">
                            <span class="contact-label" style="color: #E74C3C;">Адрес:</span><br>
                            г. Челябинск, ул. Братьев Кашириных,<br>
                            73 (1 этаж, офис 6)
                        </p>

                        <p class="contact-item">
                            <span class="contact-label" style="color: #E74C3C;">Телефоны:</span><br>
                            +7 (351) 777-36-55,<br>
                            +7 (951) 804-803-9
                        </p>

                        <p class="contact-item">
                            <span class="contact-label" style="color: #E74C3C;">Email:</span><br>
                            aplus174@mail.ru
                        </p>

                        <p class="contact-item">
                            <span class="contact-label" style="color: #E74C3C;">Время работы:</span><br>
                            С понедельника по пятницу,<br>
                            с 09:00 до 18:00
                        </p>
                    </div>

                    <div class="contacts-map">
                        <div style="position:relative;overflow:hidden;width:600px;height:430px;">
                            <a href="https://yandex.ru/maps/org/a_plyus/1187526621/?utm_medium=mapframe&utm_source=maps"
                                style="color:#eee;font-size:12px;position:absolute;top:0px;left:0px;">А плюс</a>
                            <a href="https://yandex.ru/maps/56/chelyabinsk/category/printing_services/184107124/?utm_medium=mapframe&utm_source=maps"
                                style="color:#eee;font-size:12px;position:absolute;top:14px;left:0px;">Полиграфические услуги в Челябинске</a>
                            <iframe src="https://yandex.ru/map-widget/v1/?ll=61.378560%2C55.174764&mode=search&oid=1187526621&ol=biz&z=16.25"
                                width="600"
                                height="430"
                                frameborder="1"
                                allowfullscreen="true"
                                style="position:relative;">
                            </iframe>
                        </div>
                        <p class="map-caption">остановка общ.транспорта «Полковая» отдельно стоящее красное кирпичное здание (рядом гипермаркет Лента)</p>
                    </div>
                </div>
                <div class="contacts-buttons">
                    <button class="contact-button feedback-button" id="feedbackButton">Форма обратной связи</button>
                    <a href="{{ route('reviews') }}"><button class="contact-button reviews-button">Отзывы</button></a>
                </div>

            </section>

        </div>

        <!-- Модальное окно формы обратной связи -->
        <div class="feedback-modal" id="feedbackModal">
            <div class="feedback-content">
                <span class="close-modal" id="closeModal">&times;</span>
                <h2 style="color: #2c3e50; margin-bottom: 20px;">Форма обратной связи</h2>
                <form class="feedback-form" id="feedbackForm">
                    <div class="form-group">
                        <label for="name">Ваше имя</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="message">Сообщение</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Отправить</button>
                </form>
            </div>
        </div>

        @include('page-elements.footer')

    </div>

    <script>
        // Отправка формы обратной связи (если она есть на странице)
        document.getElementById('feedbackForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            try {
                const res = await fetch("{{ route('feedback.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await res.json();
                alert(data.message);
                this.reset();
                document.getElementById('feedbackModal')?.style?.setProperty('display', 'none');
            } catch (error) {
                alert('Ошибка при отправке формы.');
            }
        });
    </script>

</body>

</html>