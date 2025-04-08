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
    @vite(['resources/css/constructor-page.css'])
    @vite(['resources/css/footer.css'])
    <title>Конструктор заказов</title>

</head>

<body class="constructor-page">
    @include('page-elements.header')

    <main class="constructor-container">
        <h1 class="constructor-title">Конструктор заказов</h1>

        <div class="template-types">
            <button class="type-button active" data-type="business_card">Визитки</button>
            <button class="type-button" data-type="booklet">Буклеты</button>
            <button class="type-button" data-type="flyer">Листовки</button>
        </div>

        <div class="templates-grid">
            @foreach($cardTemplates as $template)
            <div class="template-card">
                <img src="{{ asset('storage/' . $template->thumbnail) }}" alt="{{ $template->name }}">
                <h3>{{ $template->name }}</h3>
                <a href="{{ route('constructor.select', ['type' => $template->type, 'id' => $template->id]) }}"
                    class="btn btn-success">
                    Выбрать этот шаблон
                </a>
            </div>
            @endforeach
        </div>
    </main>

    @include('page-elements.footer')

    @push('scripts')
    <script>
        // Активация кнопок фильтрации шаблонов
        document.querySelectorAll('.type-button').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.dataset.type;

                // Удаляем активный класс у всех кнопок
                document.querySelectorAll('.type-button').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Добавляем активный класс текущей кнопке
                this.classList.add('active');

                fetch(`/constructor/templates/${type}`)
                    .then(response => response.json())
                    .then(data => {
                        // Обновление grids-сетки с шаблонами
                    });
            });
        });
    </script>
    @endpush
</body>

</html>