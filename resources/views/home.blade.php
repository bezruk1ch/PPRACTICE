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

    @include('page-elements.slide')

    @include('page-elements.constructor')

    @include('page-elements.portfolio')

    @include('page-elements.reviews')

    @include('page-elements.contacts-main')

    @include('page-elements.footer')
</body>

</html>