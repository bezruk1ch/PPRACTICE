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

        <!-- Модальное окно для добавления элемента конструктора -->
        <div id="interactiveModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Добавить элемент</h2>
                <select id="interactiveType">
                    <option value="card">Карточка</option>
                    <option value="test1">Тест 1</option>
                    <option value="test2">Тест 2</option>
                    <option value="test3">Тест 3</option>
                </select>

                <!-- Поля для добавления карточки -->
                <div id="cardFields" style="display: none;">
                    <input type="text" id="cardImage" placeholder="URL изображения">
                    <input type="text" id="cardLabel" placeholder="Текст на карточке">
                    <input type="text" id="cardButton" placeholder="Текст кнопки">
                </div>

                <!-- Поля для добавления теста -->
                <div id="test1Fields" style="display: none;">
                    <input type="text" id="test1Question" placeholder="Вопрос">
                    <input type="text" id="test1ButtonText" placeholder="Текст кнопки">
                </div>

                <div id="test2Fields" style="display: none;">
                    <input type="text" id="test2Question" placeholder="Вопрос">
                    <input type="number" id="test2OptionsCount" placeholder="Количество вариантов">
                </div>

                <div id="test3Fields" style="display: none;">
                    <input type="text" id="test3Question" placeholder="Вопрос">
                    <input type="number" id="test3ImagesCount" placeholder="Количество изображений">
                </div>

                <button onclick="addInteractiveElement()">Добавить элемент</button>
            </div>
        </div>

        <!-- Кнопка для открытия модального окна -->
        <button onclick="openModal()">Открыть конструктор</button>
    </div>

    @include('page-elements.footer')

    @section('scripts')
        <script>
            // Вставляем все JavaScript функции, которые ты прислал, сюда.

            // Открытие и закрытие модального окна
            function openModal() {
                document.getElementById('interactiveModal').style.display = 'block';
            }

            document.querySelector('.close').onclick = function() {
                document.getElementById('interactiveModal').style.display = 'none';
            };

            // Обновление полей в зависимости от выбранного типа
            function updateCardFields() {
                const type = document.getElementById('interactiveType').value;
                document.getElementById('cardFields').style.display = (type === 'card') ? 'block' : 'none';
                document.getElementById('test1Fields').style.display = (type === 'test1') ? 'block' : 'none';
                document.getElementById('test2Fields').style.display = (type === 'test2') ? 'block' : 'none';
                document.getElementById('test3Fields').style.display = (type === 'test3') ? 'block' : 'none';
            }

            document.getElementById('interactiveType').addEventListener('change', updateCardFields);
            updateCardFields();

            // Функция для добавления элемента в рабочее пространство
            function addInteractiveElement() {
                const type = document.getElementById('interactiveType').value;
                const workspace = document.getElementById('workspace');
                let newElement;

                if (type === 'card') {
                    const image = document.getElementById('cardImage').value;
                    const label = document.getElementById('cardLabel').value;
                    const buttonText = document.getElementById('cardButton').value;

                    newElement = document.createElement('div');
                    newElement.style.border = '1px solid #ddd';
                    newElement.innerHTML = `
                        <img src="${image}" alt="${label}" style="width: 100px; height: 100px;">
                        <p>${label}</p>
                        <button>${buttonText}</button>
                    `;
                } else if (type === 'test1') {
                    const question = document.getElementById('test1Question').value;
                    const buttonText = document.getElementById('test1ButtonText').value;

                    newElement = document.createElement('div');
                    newElement.innerHTML = `
                        <p>${question}</p>
                        <input type="text" placeholder="Введите ответ">
                        <button>${buttonText}</button>
                    `;
                } else if (type === 'test2') {
                    const question = document.getElementById('test2Question').value;
                    const optionsCount = document.getElementById('test2OptionsCount').value;

                    newElement = document.createElement('div');
                    newElement.innerHTML = `<p>${question}</p>`;
                    for (let i = 1; i <= optionsCount; i++) {
                        newElement.innerHTML += `
                            <input type="radio" name="test2Answer" id="option${i}">
                            <label for="option${i}">Option ${i}</label>
                        `;
                    }
                } else if (type === 'test3') {
                    const question = document.getElementById('test3Question').value;
                    const imagesCount = document.getElementById('test3ImagesCount').value;

                    newElement = document.createElement('div');
                    newElement.innerHTML = `<p>${question}</p>`;
                    for (let i = 1; i <= imagesCount; i++) {
                        newElement.innerHTML += `
                            <img src="image${i}.jpg" alt="Option ${i}" style="width: 100px; height: 100px;">
                            <input type="radio" name="test3Answer" id="option${i}">
                        `;
                    }
                }

                newElement.style.position = 'absolute';
                newElement.style.left = '100px';
                newElement.style.top = '100px';
                newElement.onclick = function() {
                    if (confirm('Удалить элемент?')) {
                        this.remove();
                    }
                };
                workspace.appendChild(newElement);
            }
        </script>
    @endsection
</body>

</html>
