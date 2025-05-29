
document.addEventListener('DOMContentLoaded', () => {

    /*
    // === ИНИЦИАЛИЗАЦИЯ ===
    const canvas = document.getElementById('canvas');
    let draggedElement = null;
    let offsetX = 0;
    let offsetY = 0;
    let selectedElement = null;
    window.selectedElement = selectedElement;
    let resizing = false;
    let resizingElement = null;
    let resizingHandle = null;
    let startX = 0, startWidth = 0;
    let startLeft = 0;
    let currentZIndex = 1;
    */



    function handleMouseUp(e) {
        const didDragOrResize = !!draggedElement || resizing;

        if (draggedElement) {
            draggedElement.style.cursor = 'default';
            draggedElement = null;
        }

        resizing = false;
        resizingElement = null;
        resizingHandle = null;

        if (didDragOrResize) {
            // сохраняем состояние **после** того, как координаты/размер изменились
        }
    }

    function handleMouseDown(e) {
        // Если выбранный элемент заблокирован — ничего не делаем
        if (selectedElement?.classList.contains('locked')) {
            e.preventDefault();
            return;
        }

        // Режим изменения размера
        if (e.target.classList.contains('resize-handle')) {
            const parent = e.target.parentElement;
            if (parent.getAttribute('data-editing') === 'true') return;
            resizing = true;
            resizingElement = parent;
            resizingHandle = e.target;
            // сохраняем начальные координаты
            const rect = parent.getBoundingClientRect();
            const canvasRect = canvas.getBoundingClientRect();
            startX = e.clientX;
            startY = e.clientY;
            startWidth = rect.width;
            startHeight = rect.height;
            startLeft = rect.left - canvasRect.left;
            startTop = rect.top - canvasRect.top;
            return;
        }

        // Режим перетаскивания: только если не в режиме редактирования
        if (e.target.classList.contains('draggable') &&
            e.target.getAttribute('data-editing') !== 'true') {
            draggedElement = e.target;
            const rect = draggedElement.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
            draggedElement.style.cursor = 'move';
        }
    }


    function handleMouseMove(e) {
        // Отключаем перемещение в режиме редактирования или если элемент заблокирован
        if (draggedElement?.getAttribute('data-editing') === 'true' || draggedElement?.classList.contains('locked')) return;

        // Перетаскивание
        if (draggedElement && !resizing) {
            const canvasRect = canvas.getBoundingClientRect();
            let newX = e.clientX - canvasRect.left - offsetX;
            let newY = e.clientY - canvasRect.top - offsetY;

            // Ограничиваем движение границами холста
            newX = Math.max(0, Math.min(newX, canvasRect.width - draggedElement.offsetWidth));
            newY = Math.max(0, Math.min(newY, canvasRect.height - draggedElement.offsetHeight));

            draggedElement.style.left = `${newX}px`;
            draggedElement.style.top = `${newY}px`;
        }

        // Изменение размера
        if (resizing && resizingElement && resizingHandle) {
            const dx = e.clientX - startX;
            if (resizingHandle.classList.contains('e')) {
                const newW = Math.max(20, startWidth + dx);
                resizingElement.style.width = `${newW}px`;
                resizingElement.style.height = 'auto';
            } else if (resizingHandle.classList.contains('w')) {
                const newW = Math.max(20, startWidth - dx);
                resizingElement.style.width = `${newW}px`;
                resizingElement.style.left = `${startLeft + dx}px`;
                resizingElement.style.height = 'auto';
            }
        }
    }

    // === ГЛОБАЛЬНЫЕ ОБРАБОТЧИКИ ДЛЯ ПЕРЕМЕЩЕНИЯ И РЕСАЙЗА ===
    canvas.addEventListener('mousedown', handleMouseDown);
    document.addEventListener('mousemove', handleMouseMove);
    document.addEventListener('mouseup', handleMouseUp);




    // === ОЧИСТКА ХОЛСТА ===
    window.clearCanvas = function () {
        const canvas = document.getElementById('canvas');

        // Удаляем все элементы с классом draggable
        canvas.querySelectorAll('.draggable').forEach(el => el.remove());

        // Сброс фона холста
        canvas.style.backgroundImage = 'none';
        canvas.style.backgroundColor = 'transparent';

        // Снимаем выделение с объектов
        document.querySelectorAll('.selected').forEach(el => el.classList.remove('selected'));

        // Сброс переменных выбранного элемента, если используются
        window.selectedElement = null;
        window.editingTextElement = null;

        // Сброс панели редактирования
        if (typeof window.showEditor === 'function') {
            window.showEditor('default');
        }
    };



    // === СОХРАНЕНИЕ МАКЕТА ===
    window.saveDesign = function () {
        const elements = document.querySelectorAll('#canvas .draggable');
        const layout = [];

        elements.forEach(el => {
            layout.push({
                type: el.tagName === 'IMG' ? 'image' : 'text',
                content: el.tagName === 'IMG' ? el.src : el.innerText,
                x: el.style.left,
                y: el.style.top
            });
        });

        console.log('Макет:', layout);
        alert('Макет сохранён в консоль (пока для теста)');
    };


    // === ДОБАВЛЕНИЕ ТЕКСТА ===
    window.addText = function (type) {
        const newText = document.createElement('div');
        newText.classList.add('draggable', 'text-element');
        newText.contentEditable = false;
        newText.style.userSelect = 'none';
        newText.innerText = getDefaultText(type);
        applyTextStyle(newText, type);
        newText.style.position = 'absolute';
        newText.style.zIndex = currentZIndex++;
        newText.style.visibility = 'hidden';

        canvas.appendChild(newText);

        // позиционируем по центру
        requestAnimationFrame(() => {
            const left = (canvas.clientWidth - newText.clientWidth) / 2;
            const top = (canvas.clientHeight - newText.clientHeight) / 2;
            newText.style.left = `${left}px`;
            newText.style.top = `${top}px`;
            newText.style.visibility = 'visible';
        });

        // Добавляем боковые ручки
        ['e', 'w'].forEach(pos => {
            const handle = document.createElement('div');
            handle.className = `resize-handle ${pos}`;
            newText.appendChild(handle);
            handle.addEventListener('mousedown', e => {
                e.preventDefault();
                e.stopPropagation();
                initResize(newText, pos, e);
            });
        });

        // вместо одного input — оба события:
        newText.addEventListener('input', () => {

            showHandlesIfEditing();
        });
        newText.addEventListener('keyup', showHandlesIfEditing);

        // Обработчик потери фокуса (закрытие режима редактирования)
        newText.addEventListener('blur', () => {

        });

        newText.addEventListener('keydown', e => {
            if (e.key === 'Escape') newText.blur();
        });
    };

    // === УТИЛИТЫ ===
    function selectAllText(el) {
        const range = document.createRange();
        range.selectNodeContents(el);
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }


    function applyTextStyle(el, type) {
        switch (type) {
            case 'heading':
                el.style.fontSize = '32px'; el.style.fontWeight = 'normal'; break;
            case 'subheading':
                el.style.fontSize = '24px'; el.style.fontWeight = 'normal'; break;
            default:
                el.style.fontSize = '16px'; el.style.fontWeight = 'normal';
        }
        el.style.fontFamily = 'Arial';
        el.style.color = '#000000';
        el.style.whiteSpace = 'pre-wrap';
        el.style.wordBreak = 'break-all';
        el.style.minHeight = '1em';
    }

    function getDefaultText(type) {
        switch (type) {
            case 'heading': return 'Заголовок';
            case 'subheading': return 'Подзаголовок';
            default: return 'Введите текст';
        }
    }


    // 1) вычисление minWidth
    function computeMinWidth(el) {
        // Возьмём первую букву текста (или 'M', если текста нет)
        const char = (el.innerText && el.innerText[0]) || 'M';
        // Создаём клон с тем же шрифтом
        const clone = document.createElement('div');
        clone.style.visibility = 'hidden';
        clone.style.position = 'absolute';
        clone.style.whiteSpace = 'nowrap';
        // Скопируем font свойства
        const cs = getComputedStyle(el);
        clone.style.font = cs.font;
        clone.innerText = char;
        document.body.appendChild(clone);
        const minW = clone.clientWidth + 4; // небольшой запас
        clone.remove();
        return minW;
    }

    // === РЕЗАЙЗ С ИНДИКАТОРОМ ===
    function initResize(el, handlePos, startEvent) {
        // сразу метим «мы ресайзим»
        resizing = true;
        const canvasRect = canvas.getBoundingClientRect();
        const startX = startEvent.clientX;
        const startLeft = el.getBoundingClientRect().left - canvasRect.left;
        const startWidth = el.getBoundingClientRect().width;
        const minWidth = computeMinWidth(el);

        const indicator = document.createElement('div');
        Object.assign(indicator.style, {
            position: 'fixed',
            zIndex: '9999',
            background: 'rgba(0,0,0,0.7)',
            color: '#fff',
            padding: '2px 6px',
            borderRadius: '4px',
            pointerEvents: 'none'
        });
        document.body.appendChild(indicator);

        function onMouseMove(e) {
            const dx = e.clientX - startX;
            let rawWidth = handlePos === 'e' ? startWidth + dx : startWidth - dx;
            const newWidth = Math.max(minWidth, rawWidth);

            if (handlePos === 'w') {
                // смещение левой границы только пока не меньше minWidth
                const shift = rawWidth >= minWidth ? dx : (startWidth - minWidth);
                el.style.left = `${startLeft + shift}px`;
            }
            el.style.width = `${newWidth}px`;
            el.style.height = 'auto';

            // позиционирование индикатора прямо у курсора
            indicator.innerText = `${Math.round(newWidth)}×${Math.round(el.getBoundingClientRect().height)}`;
            indicator.style.left = `${e.clientX}px`;
            indicator.style.top = `${e.clientY}px`;


        }

        function onMouseUp() {
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            indicator.remove();

            // сбрасываем режим ресайза
            resizing = false;

            // восстанавливаем выделение и панель
            selectedElement = el;
            el.classList.add('selected');
            el.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'block');
            showTextEditPanel(el);

            // возвращаем фокус в текст, чтобы не произошло blur
            if (el.getAttribute('data-editing') === 'true') {
                el.focus();
            }


        }

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
    }

    // === ВИЗУАЛИЗАЦИЯ РУЧЕК И ПУНКТИРНЫЙ КОНТУР ===
    // 1. Одиночный клик — выбор
    canvas.addEventListener('click', e => {
        if (e.target.closest('.text-edit-panel') || e.target.closest('.image-edit-panel')) return;

        if (e.target.classList.contains('text-element') || e.target.tagName === 'IMG') {
            if (selectedElement?.getAttribute('data-editing') === 'true') return;

            // Снимаем старое выделение
            if (selectedElement) {
                selectedElement.classList.remove('selected');
                selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
            }

            // Новое выделение
            selectedElement = e.target;
            window.selectedElement = selectedElement;   // ← обновляем глобальную переменную
            selectedElement.classList.add('selected');
            if (selectedElement.classList.contains('text-element')) {
                selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'block');
            }

            // Показываем панель
            if (selectedElement.classList.contains('text-element')) {
                showEditor('text');
                showTextEditPanel();   // теперь text-editor-panel.js увидит window.selectedElement
            } else {
                showEditor('image');
            }

        } else {
            // Клик вне — сброс
            if (selectedElement) {
                selectedElement.classList.remove('selected');
                selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
                if (selectedElement.getAttribute('data-editing') === 'true') {
                    selectedElement.contentEditable = false;
                    selectedElement.removeAttribute('data-editing');
                }
            }
            selectedElement = null;
            window.selectedElement = null;  // ← сбрасываем глобально
            hideTextEditPanel();
            showEditor('default');
        }
    });


    // 2. Двойной клик — вход в режим редактирования
    canvas.addEventListener('dblclick', e => {
        if (!e.target.classList.contains('text-element')) return;

        // Сохраняем и включаем редактирование
        selectedElement = e.target;
        window.selectedElement = selectedElement;  // ← чтобы модуль видел новый элемент
        selectedElement.contentEditable = true;
        selectedElement.setAttribute('data-editing', 'true');
        selectedElement.style.cursor = 'text';
        selectedElement.style.userSelect = 'text';
        selectedElement.focus();
        selectAllText(selectedElement);

        // Показываем панель редактирования
        showTextEditPanel();   // теперь ищет window.selectedElement
        showEditor('text');
    });


    function showHandlesIfEditing() {
        if (selectedElement?.getAttribute('data-editing') === 'true') {
            selectedElement.querySelectorAll('.resize-handle')
                .forEach(h => h.style.display = 'block');
        }
    }

    // === ДОБАВЛЕНИЕ ИЗОБРАЖЕНИЯ ===
    window.addImage = function () {
        const imageInput = document.createElement('input');
        imageInput.type = 'file';
        imageInput.accept = 'image/*';

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                const newImage = document.createElement('img');
                newImage.classList.add('draggable');
                newImage.src = event.target.result;
                newImage.style.maxWidth = '200px';
                newImage.style.maxHeight = '200px';
                newImage.style.position = 'absolute';
                newImage.style.visibility = 'hidden';
                canvas.appendChild(newImage);



                newImage.onload = () => {
                    const canvasRect = canvas.getBoundingClientRect();
                    const imgRect = newImage.getBoundingClientRect();

                    const left = (canvas.clientWidth - imgRect.width) / 2;
                    const top = (canvas.clientHeight - imgRect.height) / 2;

                    newImage.style.left = `${left}px`;
                    newImage.style.top = `${top}px`;
                    newImage.style.visibility = 'visible';

                    addResizeHandles(newImage);
                };
            };

            reader.readAsDataURL(file);
        });

        imageInput.click();
    };

    function addResizeHandles(image) {
        const positions = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
        positions.forEach(pos => {
            const handle = document.createElement('div');
            handle.classList.add('resize-handle', pos);
            image.appendChild(handle);

            handle.addEventListener('mousedown', (e) => {
                e.stopPropagation();
                resizing = true;
                resizingElement = image;
                resizingHandle = handle;
                startX = e.clientX;
                startY = e.clientY;
                startWidth = image.offsetWidth;
                startHeight = image.offsetHeight;
            });
        });
    }



});


