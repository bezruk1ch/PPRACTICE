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
    @vite(['resources/css/about-us.css'])
    @vite(['resources/css/footer.css'])
    <title>Главная страница</title>

</head>

<body class="m-0 bg-[#2C3E50]">
    <div class="page-wrapper">

        @include('page-elements.header')

        <div class="page-content">

            <div class="section">
                <div class="section-title">О нас</div>
                <div class="subsection-title">История компании</div>
                <div class="section-container">
                    <div class="subsection-1">
                        <div class="box-text-1">
                            <div class="year-box">2013</div>
                            <div class="text-content">
                                Типография А ПЛЮС начала свою работу в 2013 году. Самыми первыми и постоянными заказами типографии были нанесения фирменного логотипа на специальную одежду и средства индивидуальной защиты, путём переноса специальной плёнки под давлением и при высокой температуре (термопечать или термоперенос), а так же путём шелкографии. У нас был минимальный набор оборудования: трафаретный станок, термопрес, принтер, режущий плоттер. В компании работало два специалиста. Все заработанные средства вкладывались в развитие, что позволило молодой компании расти быстрыми темпами.
                            </div>
                        </div>
                        <img src="{{ asset('img/about-us/about-us-1.png') }}" alt="Изображение" class="image-content-1">
                    </div>
                    <div class="subsection-2">
                        <img src="{{ asset('img/about-us/about-us-2.png') }}" alt="Изображение" class="image-content-2">
                        <div class="box-text-2">
                            <div class="year-box-2">2014</div>
                            <div class="text-content-2">
                                Постепенно ТИПОГРАФИЯ А ПЛЮС осваивала разные направления и расширяла спектр услуг различных видов печати, ориентируясь на заказчиков и создавая для них широкий спектр возможностей.<br><br>

                                Изготовление визиток, широкоформатная печать, услуги дизайна, бланки, объявления, листовки, сувенирная продукция, оформление входных групп, изготовление бегущих строк — все это требует участия квалифицированных специалистов, имеющих опыт работы в самых узких областях полиграфии. Так с увеличением объема предоставляемых услуг расширился наш штат персонала.<br><br>

                                Менеджер – человек, осуществляющий прием и сортировку заказов, отвечающий за маркетинг.
                                Дизайнер – разрабатывает проекты, подготовку к печати.
                                Печатник – осуществляет трудоемкий процесс работы;
                                Постпечатник– проводит после печатную обработку.
                                Команда монтажников – выезды на объекты, замеры, сборка и монтаж наружной рекламы , повышает трудовые резервы.
                                Бухгалтер - документальное ведение хозяйственного и финансового учета на предприятии.
                            </div>
                        </div>
                    </div>
                    <div class="subsection-3">
                        <div class="box-text-3">
                            <div class="year-box">2017</div>
                            <div class="text-content">
                                Помимо модернизации производственной базы и расширения штата, был организован склад материалов для производства наружной рекламы, вывесок, световых букв и коробов. Компания постепенно перешла к более совершенному оборудованию, что позволило повысить уровень качества выпускаемой продукции и значительно увеличить объемы производства.
                            </div>
                        </div>
                        <img src="{{ asset('img/about-us/about-us-3.png') }}" alt="Изображение" class="image-content-3">
                    </div>
                    <div class="subsection-4">
                        Сегодня «А плюс» – широкопрофильная типография в Челябинске, которая обеспечивает надежность, качество и оперативность предоставляемых полиграфических услуг. Наше предприятие оснащено современным оборудованием, которое позволяет делать упор как на качество, так и на объем и скорость изготовления продукции.
                    </div>
                </div>
            </div>

        </div>

        @include('page-elements.footer')

    </div>
</body>

</html>