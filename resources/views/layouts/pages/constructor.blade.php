<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конструктор визиток</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/constructor.css'])
    @vite(['resources/js/constructor.js'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&family=Oswald:wght@200;400;600&family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
</head>

<body>

    <!-- 1) Фиксированная верхняя глобальная -->
    <header class="top-bar">
        <div class="top-bar__left">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ asset('img/header/logo.png') }}" alt="Логотип" class="logo-img"></a>
                <div class="logo-text">А ПЛЮС</div>
            </div>
            <nav class="site-nav">
                <a href="#">Главная</a>
                <a href="#">Вход</a>
                <a href="#">Регистрация</a>
            </nav>
        </div>
        <div class="top-bar__right">
            <button class="download-btn">Скачать макет</button>
        </div>
    </header>

    <div class="editor-bar-toolbox">

        <!-- 3) Левая панель -->
        <aside id="toolbox">
            <button class="tool-item" data-tool="text">Текст</button>
            <button class="tool-item" data-tool="background">Фон</button>
            <button class="tool-item" data-tool="images">Картинки</button>
            <button class="tool-item" data-tool="elements">Элементы</button>
            <button class="tool-item" data-tool="base">Основа</button>
        </aside>

        <!-- 4) Вторая выезжающая панель (справа от main-toolbox) -->
        <aside id="slide-toolbox">
            <button id="closeSlide" class="slide-close">×</button>

            <div id="text-options" class="toolbox-section" style="display: none;">
                <p><strong>Кликните по тексту, чтобы добавить его в рабочую область:</strong></p>
                <a href="#" onclick="addText('heading')">Заголовок</a><br>
                <a href="#" onclick="addText('subheading')">Подзаголовок</a><br>
                <a href="#" onclick="addText('paragraph')">Обычный текст</a>
            </div>

            <!-- Фон -->
            <div id="background-options" class="toolbox-section" style="display: none;">
                <h3 class="section-title">Фон</h3>
                <div class="section-group">
                    <button class="tool-btn">Заливка цветом</button>
                    <input type="color" class="color-picker" value="#ffffff">
                    <button class="tool-btn">Загрузить с компьютера</button>
                    <input type="file" accept="image/*" class="upload-input">
                </div>
            </div>

            <!-- Картинки -->
            <div id="images-options" class="toolbox-section" style="display: none;">
                <h3 class="section-title">Картинки</h3>
                <div class="section-group">
                    <button class="tool-btn">Загрузить с компьютера</button>
                    <input type="file" accept="image/*" class="upload-input">

                    <button id="addByUrlBtn" class="tool-btn">Добавить по ссылке</button>
                    <input type="text" id="urlInput" placeholder="https://..." class="text-input">
                </div>
            </div>

            <!-- Элементы -->
            <div id="elements-options" class="toolbox-section" style="display: none;">
                <h3 class="section-title">Элементы</h3>
                <div class="section-group">
                    <button class="tool-btn">Фигуры и линии</button>
                    <button class="tool-btn">Коллекция иконок</button>
                </div>
            </div>

            <!-- Основа -->
            <div id="base-options" class="toolbox-section" style="display: none;">
                <h3 class="section-title">Основа</h3>
                <div class="section-group">
                    <button class="tool-btn">Визитка</button>
                    <button class="tool-btn">Футболка</button>
                    <button class="tool-btn">Постер</button>
                    <button class="tool-btn">Буклет</button>
                    <!-- можно добавить другие -->
                </div>
            </div>
        </aside>


        <div class="editor-bar-canvas">

            <!-- 2) Вторая верхняя панель (редактор-бар) -->
            <section class="editor-bar">
                <!-- содержимое будет заменяться по клику на объекты -->
                <div id="editor-controls" class="editor-bar__inner"></div>
            </section>

            <!-- 5) Основная рабочая зона с холстом -->
            <section class="canvas-wrapper" id="canvas-wrapper">
                <div class="canvas-area">
                    <!-- Кнопки над холстом -->
                    <div class="canvas-controls-top">
                        <button id="copySideBtn" class="side-btn">Скопировать сторону</button>
                        <button id="clearSideBtn" class="side-btn">Очистить сторону</button>
                    </div>

                    <!-- Сам холст -->
                    <div id="canvas">
                        <div class="safety-lines">
                            <div class="safety-line top"></div>
                            <div class="safety-line right"></div>
                            <div class="safety-line bottom"></div>
                            <div class="safety-line left"></div>
                        </div>
                        <!-- сюда добавляются draggable элементы -->
                    </div>

                    <!-- Кнопки под холстом -->
                    <div class="canvas-controls-bottom">
                        <div class="side-switch">
                            <button id="frontSideBtn" class="side-btn active">Лицевая сторона</button>
                            <button id="backSideBtn" class="side-btn">Оборотная сторона</button>
                        </div>
                        <button id="proceedBtn" class="action-btn">Продолжить</button>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!-- Скрытые шаблоны для динамического наполнения .editor-bar -->
    <!-- шаблон базовых действий -->
    <template id="tpl-actions-default">
        <div class="editor-actions">
            <button id="undoBtn" class="action-btn">← Отменить</button>
            <button id="redoBtn" class="action-btn">Вернуть →</button>
            <button id="saveBtn" class="action-btn" onclick="saveDesign()">Сохранить макет</button>
            <button id="clearBtn" class="action-btn" onclick="clearCanvas()">Очистить</button>
        </div>
    </template>

    <!-- шаблон лишь для текстовых контролов -->
    <template id="tpl-actions-text">
        <div class="text-edit-panel">
            <!-- Выбор шрифта -->
            <select id="fontSelect" title="Шрифт" onchange="onFontChange()">
                <option value="Arial">Arial</option>
                <option value="Verdana">Verdana</option>
                <option value="Georgia">Georgia</option>
                <option value="Courier New">Courier New</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Oswald">Oswald</option>
                <option value="Roboto">Roboto</option>
            </select>

            <!-- Размер шрифта -->
            <input id="fontSizeInput" title="Размер шрифта" type="number" min="8" max="120" onchange="onFontSizeChange()">

            <!-- Цвет текста -->
            <input id="fontColorInput" title="Цвет текста" type="color" onchange="onFontColorChange()">

            <!-- Жирный / Курсив / Подчёркнутый / Верхний регистр -->
            <button title="Жирный" onclick="applyBold()">B</button>
            <button title="Курсив" onclick="applyItalic()">I</button>
            <button title="Подчёркнутый" onclick="applyUnderline()">U</button>
            <button title="Регистр" onclick="applyUppercase()">Aa</button>

            <!-- Выравнивание текста -->
            <button id="alignBtn" onclick="toggleAlign()" title="Выравнивание">⬅️</button>
            <!--<div>
                <button onclick="alignText('left')">⯇</button>
                <button onclick="alignText('center')">↔</button>
                <button onclick="alignText('right')">⯈</button>
            </div> -->

            <!-- Слои и выравнивание по холсту -->
            <div class="dropdown">
                <button class="dropdown-toggle" title="Слои и выравнивание">📐</button>
                <div class="dropdown-menu">
                    <div><span>📤</span> <button onclick="bringForward()">На передний план</button></div>
                    <div><span>📥</span> <button onclick="sendBackward()">На задний план</button></div>
                    <hr>
                    <div><span>🔼</span> <button onclick="alignToCanvas('safe-top')">По верхнему краю</button></div>
                    <div><span>🔽</span> <button onclick="alignToCanvas('safe-bottom')">По нижнему краю</button></div>
                    <div><span>↔️</span> <button onclick="alignToCanvas('center')">По центру (гор.)</button></div>
                    <div><span>↕️</span> <button onclick="alignToCanvas('middle')">По центру (верт.)</button></div>
                    <div><span>⬅️</span> <button onclick="alignToCanvas('safe-left')">По левому краю</button></div>
                    <div><span>➡️</span> <button onclick="alignToCanvas('safe-right')">По правому краю</button></div>
                </div>
            </div>

            <!-- Фиксация -->
            <button id="lockElement" title="Фиксировать" onclick="toggleLockElement()">🔒</button>

            <!-- Параметры -->
            <div class="dropdown">
                <button class="dropdown-toggle" title="Параметры">⚙️</button>
                <div class="dropdown-menu">
                    <label>Межбуквенный интервал
                        <input id="letterSpacingInput" type="range" min="0" max="20" step="1" onchange="onLetterSpacingChange()">
                    </label>
                    <label>Межстрочный интервал
                        <input id="lineHeightInput" type="range" min="1" max="3" step="0.1" onchange="onLineHeightChange()">
                    </label>
                    <label>Прозрачность
                        <input id="opacityInput" type="range" min="0" max="1" step="0.01" value="1" onchange="onOpacityChange()">
                    </label>
                </div>
            </div>


            <!-- Копировать и удалить -->
            <button onclick="copyElement()" title="Копировать">📄</button>
            <button onclick="deleteElement()" title="Удалить">🗑️</button>
        </div>
    </template>

    <template id="tpl-actions-image">
        <div class="image-edit-panel" style="display:flex; gap:10px; padding:12px; background:#1e1e1e; border-radius:12px;">
            <button onclick="bringForward()">⬆️ Вперёд</button>
            <button onclick="sendBackward()">⬇️ Назад</button>
            <label>Ширина:
                <input id="imgWidthInput" type="number" min="10" onchange="onImageWidthChange()">
            </label>
            <label>Поворот:
                <input id="imgRotateInput" type="number" min="0" max="360" onchange="onImageRotateChange()">
            </label>
            <button onclick="deleteElement()">🗑️ Удалить</button>
        </div>
    </template>

    <!-- всплывающее окно проверки макета -->
    <div id="preview-modal" class="preview-modal">
        <div class="preview-content">
            <h2 class="preview-title">Проверьте ваш макет</h2>
            <ul class="preview-list">
                <li>Информация размещена верно и без ошибок</li>
                <li>Изображения чёткие и не размытые</li>
                <li>Текст разборчив и не сливается с фоном</li>
                <li>Элементы не накладываются друг на друга</li>
            </ul>
            <div class="preview-buttons">
                <button class="btn preview-btn" data-action="front">Лицевая сторона</button>
                <button class="btn preview-btn" data-action="back">Оборотная сторона</button>
                <button class="btn preview-btn" data-action="order">Сделать заказ</button>
                <button class="btn preview-btn" data-action="download">Скачать макет</button>
                <button class="btn preview-btn" data-action="edit">Вернуться к редактированию</button>
            </div>
        </div>
    </div>

    <div class="zoom-controls">
        <button id="zoomOutBtn">−</button>
        <span id="zoomValue">100%</span>
        <button id="zoomInBtn">+</button>
    </div>

    <div id="downloadModal" class="modal-overlay" style="display: none;">
        <div class="modal">
            <h2>Скачать макет</h2>
            <p>Выберите формат:</p>
            <div class="modal-buttons">
                <button id="downloadJPG" class="modal-btn">JPG</button>
                <button id="downloadPDF" class="modal-btn">PDF</button>
            </div>
            <button id="closeModal" class="modal-close">×</button>
        </div>
    </div>
</body>

</html>