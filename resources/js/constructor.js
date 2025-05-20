import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

window.html2canvas = html2canvas;
window.jsPDF = jsPDF;

document.addEventListener('DOMContentLoaded', () => {

    // === ИНИЦИАЛИЗАЦИЯ ===
    const canvas = document.getElementById('canvas');
    let draggedElement = null;
    let offsetX = 0;
    let offsetY = 0;
    let selectedElement = null;
    let resizing = false;
    let resizingElement = null;
    let resizingHandle = null;
    let startX = 0,  startWidth = 0;
    let startLeft = 0 ;
    let currentZIndex = 1;

    /*

    const proceedBtn = document.getElementById('proceedBtn');
    const previewModal = document.getElementById('preview-modal');
    const previewBtns = previewModal.querySelectorAll('.preview-buttons .btn');

    //ФУНКЦИЯ ОТКРЫТИЯ МОДАЛЬНОГО ОКНА ПРИ КЛИКЕ НА КНОПКУ "ПРОДОЛЖИТЬ"
    proceedBtn.addEventListener('click', () => {
        previewModal.style.display = 'flex';
    });

    //ОБРАБОТКА КНОПОК ВНУТРИ МОДАЛЬНОГО ОКНА "ПРОВЕРЬТЕ ВАШ МАКЕТ"
    previewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.textContent.trim();

            switch (action) {
                case 'Лицевая сторона':
                    // здесь можно переключить на лицевую сторону, например:
                    document.getElementById('frontSideBtn').click();
                    break;

                case 'Оборотная сторона':
                    document.getElementById('backSideBtn').click();
                    break;

                case 'Сделать заказ':
                    // например, перенаправить на форму оформления
                    window.location.href = '/cart';
                    break;

                case 'Скачать макет':
                    // вызовем существующую логику скачивания
                    document.querySelector('.download-btn').click();
                    break;

                case 'Вернуться к редактированию':
                    // просто закроем модалку
                    previewModal.style.display = 'none';
                    break;
            }
        });
    });

    // 3. Закрыть модалку при клике вне контента
    previewModal.addEventListener('click', e => {
        if (e.target === previewModal) {
            previewModal.style.display = 'none';
        }
    }); 
    
    

    document.querySelector('.download-btn').addEventListener('click', () => {
        document.getElementById('downloadModal').style.display = 'flex';
    });

    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('downloadModal').style.display = 'none';
    });

    //ФУНКЦИЯ СКАЧАТЬ МАКЕТ
    const canvasElement = document.getElementById('canvas');

    //СКАЧАТЬ ИЗОБРАЖЕНИЕМ
    document.getElementById('downloadJPG').addEventListener('click', () => {
        html2canvas(canvasElement).then(canvas => {
            const link = document.createElement('a');
            link.download = 'макет.jpg';
            link.href = canvas.toDataURL('image/jpeg');
            link.click();
            closeModal();
        });
    });

    //СКАЧАТЬ ФАЙЛОМ
    document.getElementById('downloadPDF').addEventListener('click', () => {
        html2canvas(canvasElement).then(canvas => {
            const imgData = canvas.toDataURL('image/jpeg');
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'px',
                format: [canvas.width, canvas.height]
            });
            pdf.addImage(imgData, 'JPEG', 0, 0, canvas.width, canvas.height);
            pdf.save('макет.pdf');
            closeModal();
        });
    });

    function closeModal() {
        document.getElementById('downloadModal').style.display = 'none';
    }
        

    */ 

    const editorControls = document.getElementById('editor-controls');

    
    function showEditor(type) {
        editorControls.innerHTML = '';
        const title = document.createElement('div');
        title.className = 'editor-title';

        if (type === 'text') {
            title.textContent = 'Редактирование текста';
            editorControls.appendChild(title);
            editorControls.appendChild(
                document.getElementById('tpl-actions-text').content.cloneNode(true)
            );
            showTextEditPanel();

        } else if (type === 'image') {
            title.textContent = 'Редактирование изображения';
            editorControls.appendChild(title);
            editorControls.appendChild(
                document.getElementById('tpl-actions-image').content.cloneNode(true)
            );
            showImageEditPanel();

        } else {
            title.textContent = 'Конструктор заказов онлайн';
            editorControls.appendChild(title);
        }

        // базовые действия
        const defTpl = document.getElementById('tpl-actions-default');
        editorControls.appendChild(defTpl.content.cloneNode(true));
    }

    // при загрузке — показываем дефолт
    showEditor('default');

     /*

    const slideToolbox = document.getElementById('slide-toolbox');
    const sections = slideToolbox.querySelectorAll('.toolbox-section');

    // Сейчас открытая вкладка (или null)
    let currentTool = null;

    document.querySelectorAll('[data-tool]').forEach(button => {
        button.addEventListener('click', e => {
            e.stopPropagation();

            const tool = button.dataset.tool;
            const targetSection = document.getElementById(`${tool}-options`);
            if (!targetSection) return;

            // Если кликнули по той же кнопке, что уже открыта — закрываем панель
            if (slideToolbox.classList.contains('visible') && currentTool === tool) {
                slideToolbox.classList.remove('visible');
                sections.forEach(sec => sec.style.display = 'none');
                currentTool = null;
                return;
            }

            // Иначе — открываем нужную секцию
            slideToolbox.classList.add('visible');
            sections.forEach(sec => sec.style.display = 'none');
            targetSection.style.display = 'block';
            currentTool = tool;
        });
    });

    // По крестик просто закрываем
    document.getElementById('closeSlide').addEventListener('click', () => {
        slideToolbox.classList.remove('visible');
        sections.forEach(sec => sec.style.display = 'none');
        currentTool = null;
    });

    // ——— Функционал для вкладки «Фон» ———
    const bgSection = document.getElementById('background-options');

    // 1) Заливка цветом
    bgSection.querySelector('.color-picker').addEventListener('input', e => {
        const color = e.target.value;
        document.getElementById('canvas').style.backgroundColor = color;
    });

    // 2) Загрузить изображение-фон с компьютера
    bgSection.querySelector('.upload-input').addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            const canvas = document.getElementById('canvas');
            canvas.style.backgroundImage = `url(${ev.target.result})`;
            canvas.style.backgroundSize = 'cover';
        };
        reader.readAsDataURL(file);
    });

    // ——— Функционал для вкладки «Картинки» ———
    const imgSection = document.getElementById('images-options');

    // 1) Загрузка с компьютера
    imgSection.querySelector('.upload-input').addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => insertImageOnCanvas(ev.target.result);
        reader.readAsDataURL(file);
    });

    // 2) Добавление по ссылке
    const addByUrlBtn = document.getElementById('addByUrlBtn');
    const urlInput = document.getElementById('urlInput');

    addByUrlBtn.addEventListener('click', () => {
        const url = urlInput.value.trim();
        if (url) {
            insertImageOnCanvas(url);
            urlInput.value = '';
        }
    });

    // И (опционально) чтобы Enter тоже работал:
    urlInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            addByUrlBtn.click();
        }
    });

    // ——— Функционал для вкладки «Основа» ———
    const baseSection = document.getElementById('base-options');
    baseSection.querySelectorAll('.tool-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            // Сопоставление текста кнопки с шаблоном
            const map = {
                'Визитка': 'business-card',
                'Футболка': 'tshirt',
                'Постер': 'poster',
                'Буклет': 'brochure'
            };
            const key = btn.textContent.trim();
            const type = map[key] || 'custom';
            setCanvasTemplate(type);
        });
    });

    function insertImageOnCanvas(src) {
        const img = new Image();
        img.src = src;
        img.classList.add('draggable');
        img.style.position = 'absolute';
        img.style.left = '100px';
        img.style.top = '100px';
        document.getElementById('canvas').appendChild(img);
        makeElementDraggable(img);

    }

    function setCanvasTemplate(type) {
        const canvas = document.getElementById('canvas');
        // сбросим предыдущие классы
        canvas.classList.remove('tpl-tshirt', 'tpl-poster', 'tpl-business-card', 'tpl-brochure');
        // добавим нужный
        canvas.classList.add(`tpl-${type}`);

        // Очистим inline-стили фона и размеров
        canvas.style.background = '';
        canvas.style.width = '';
        canvas.style.height = '';

        // Только для футболки — задаём фон программно
        if (type === 'tshirt') {
            canvas.style.background = "url('/img/constructor/tshirt.png') no-repeat center/contain";
            canvas.style.width = '800px';
            canvas.style.height = '850px';
        }
    }

    // кнопки «Основа»
    const baseBtns = document.querySelectorAll('#base-options .tool-btn');
    const typeMap = {
        'Визитка': 'business-card',
        'Футболка': 'tshirt',
        'Постер': 'poster',
        'Буклет': 'brochure'
    };
    baseBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const type = typeMap[btn.textContent.trim()];
            setCanvasTemplate(type);
        });
    });

     */ 
     



    const canvasArea = document.querySelector('.canvas-area');
    let zoomLevel = 1;

    document.getElementById('zoomInBtn').addEventListener('click', () => {
        zoomLevel = Math.min(2, zoomLevel + 0.1);
        canvasArea.style.transform = `scale(${zoomLevel})`;
        document.getElementById('zoomValue').textContent = `${Math.round(zoomLevel * 100)}%`;
    });

    document.getElementById('zoomOutBtn').addEventListener('click', () => {
        zoomLevel = Math.max(0.5, zoomLevel - 0.1);
        canvasArea.style.transform = `scale(${zoomLevel})`;
        document.getElementById('zoomValue').textContent = `${Math.round(zoomLevel * 100)}%`;
    });



    /* const history = [];
    let historyPointer = -1;

    function saveState() {
        // удаляем «будущие» если мы сделали undo, а потом новое действие
        history.splice(historyPointer + 1);
        // сохраняем текущее содержимое canvas
        history.push(canvas.innerHTML);
        historyPointer = history.length - 1;
    }

    // отмена последнего
    function undoLastAction() {
        if (historyPointer > 0) {
            historyPointer--;
            canvas.innerHTML = history[historyPointer];
            rebindAllEventListeners(); // перепривязываем все обработчики к новым DOM-элементам
        }
    }

    // Ctrl+Z
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z') {
            e.preventDefault();
            undoLastAction();
        }
    }); */

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
        document.querySelectorAll('#canvas .draggable').forEach(el => el.remove());


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
        // игнор клика по панели
        if (e.target.closest('.text-edit-panel') || e.target.closest('.image-edit-panel')) return;

        // по тексту или картинке?
        if (e.target.classList.contains('text-element') || e.target.tagName === 'IMG') {
            // если в режиме редактирования — ничего не делаем
            if (selectedElement?.getAttribute('data-editing') === 'true') return;

            // снимаем старое выделение
            if (selectedElement) {
                selectedElement.classList.remove('selected');
                selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
            }

            // новое выделение
            selectedElement = e.target;
            selectedElement.classList.add('selected');
            if (selectedElement.classList.contains('text-element')) {
                selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'block');
            }

            // показываем панель
            if (selectedElement.classList.contains('text-element')) {
                showEditor('text');
            } else if (selectedElement.tagName === 'IMG') {
                showEditor('image');
            }

        } else {
            // клик вне — сброс
            if (selectedElement) {
                selectedElement.classList.remove('selected');
                selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
                // если был в режиме редактирования, выключаем его
                if (selectedElement.getAttribute('data-editing') === 'true') {
                    selectedElement.contentEditable = false;
                    selectedElement.removeAttribute('data-editing');
                }
            }
            selectedElement = null;
            hideTextEditPanel();
            showEditor('default');
        }
    });


    // 2. Двойной клик — вход в режим редактирования
    canvas.addEventListener('dblclick', e => {
        if (!e.target.classList.contains('text-element')) return;
        // сохраняем и включаем редактирование
        selectedElement = e.target;
        selectedElement.contentEditable = true;
        selectedElement.setAttribute('data-editing', 'true');
        selectedElement.style.cursor = 'text';
        selectedElement.style.userSelect = 'text';
        selectedElement.focus();
        selectAllText(selectedElement);

        // показываем панель редактирования
        showTextEditPanel();
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

    // === ПАНЕЛЬ РЕДАКТИРОВАНИЯ ТЕКСТА (ПОЯВЛЯЮЩАЯСЯ В EDITOR-BAR) ===
    function showTextEditPanel() {
        if (!selectedElement || !selectedElement.classList.contains('text-element')) return;
        // вставка шаблона один раз
        if (!document.querySelector('.text-edit-panel')) {
            const tpl = document.getElementById('tpl-actions-text');
            document.querySelector('.editor-bar').appendChild(tpl.content.cloneNode(true));
        }
        const panel = document.querySelector('.text-edit-panel');
        panel.style.display = 'flex';
        // заполняем контролы
        panel.querySelector('#fontSelect').value = selectedElement.style.fontFamily || 'Arial';
        panel.querySelector('#fontSizeInput').value = parseInt(selectedElement.style.fontSize) || 16;
        panel.querySelector('#fontColorInput').value = rgbToHex(getComputedStyle(selectedElement).color);
    }

    function hideTextEditPanel() {
        const panel = document.querySelector('.text-edit-panel');
        if (panel) panel.style.display = 'none';
    }

    // === ПАНЕЛЬ РЕДАКТИРОВАНИЯ ИЗОБРАЖЕНИЙ (ПОЯВЛЯЮЩАЯСЯ В EDITOR-BAR) ===
    // === ПАНЕЛЬ РЕДАКТИРОВАНИЯ ИЗОБРАЖЕНИЙ (ПОЯВЛЯЮЩАЯСЯ В EDITOR-BAR) ===
    function showImageEditPanel() {
        if (!selectedElement || selectedElement.tagName !== 'IMG') return;

        // Вставляем шаблон один раз
        if (!document.querySelector('.image-edit-panel')) {
            const tpl = document.getElementById('tpl-actions-image');
            document.querySelector('.editor-bar').appendChild(tpl.content.cloneNode(true));
        }

        const panel = document.querySelector('.image-edit-panel');
        panel.style.display = 'flex';

        // Устанавливаем текущие значения
        document.getElementById('imgWidthInput').value = parseInt(selectedElement.style.width) || selectedElement.naturalWidth;
        const rot = (selectedElement.style.transform.match(/rotate\((\d+)deg\)/) || [0, 0])[1];
        document.getElementById('imgRotateInput').value = rot;

        // Обновим текст кнопки блокировки, если нужно
    }

    // Убрал дубли, оставил одно определение:
    window.onImageWidthChange = function () {
        if (!selectedElement || selectedElement.tagName !== 'IMG') return;
        const val = document.getElementById('imgWidthInput').value;
        selectedElement.style.width = val + 'px';
        if (typeof saveState === 'function') saveState();
    };

    window.onImageRotateChange = function () {
        if (!selectedElement || selectedElement.tagName !== 'IMG') return;
        const deg = document.getElementById('imgRotateInput').value;
        selectedElement.style.transform = `rotate(${deg}deg)`;
        if (typeof saveState === 'function') saveState();
    };

    // ФУНКЦИИ ИЗМЕНЕНИЯ СТИЛЯ ТЕКСТА
    window.bringForward = function () {
        if (!selectedElement) return;
        let z = parseInt(selectedElement.style.zIndex || 1) + 1;
        selectedElement.style.zIndex = z;
        if (typeof saveState === 'function') saveState();
    };

    window.sendBackward = function () {
        if (!selectedElement) return;
        let z = parseInt(selectedElement.style.zIndex || 1);
        if (z > 1) {
            selectedElement.style.zIndex = z - 1;
            if (typeof saveState === 'function') saveState();
        }
    };

    function rgbToHex(rgb) {
        const result = rgb.match(/\d+/g);
        return result ? "#" + result.map(x => (+x).toString(16).padStart(2, '0')).join('') : '#000000';
    }

    window.rgbToHex = rgbToHex;

    window.onFontChange = function () {
        // Получаем элемент <select>
        const fontSelect = document.getElementById('fontSelect');
        const font = fontSelect.value;

        // Проверяем, что есть выделенный текстовый элемент
        if (!selectedElement || !selectedElement.classList.contains('text-element')) return;

        // Применяем шрифт
        selectedElement.style.fontFamily = font;

        // Если есть функция сохранения состояния — вызываем её
        if (typeof saveState === 'function') {
            saveState();
        }
    };

    window.onFontSizeChange = function () {
        if (!selectedElement) return;
        const val = document.getElementById('fontSizeInput').value;
        selectedElement.style.fontSize = `${val}px`;
        if (typeof saveState === 'function') saveState();
    };

    window.onFontColorChange = function () {
        if (!selectedElement) return;
        const val = document.getElementById('fontColorInput').value;
        selectedElement.style.color = val;
        if (typeof saveState === 'function') saveState();
    };

    // Кнопки форматирования (жирный, курсив, и т.д.) подключаются здесь ↓
    window.applyBold = function () {
        if (!selectedElement || !selectedElement.classList.contains('text-element')) return;
        const isBold = getComputedStyle(selectedElement).fontWeight === '700';
        selectedElement.style.fontWeight = isBold ? 'normal' : 'bold';
    };

    window.applyItalic = function () {
        if (selectedElement) {
            selectedElement.style.fontStyle = selectedElement.style.fontStyle === 'italic'
                ? selectedElement.style.fontStyle = 'normal'
                : selectedElement.style.fontStyle = 'italic';
        }
    };

    window.applyUnderline = function () {
        if (selectedElement) {
            const textDecoration = selectedElement.style.textDecoration;
            selectedElement.style.textDecoration = textDecoration === 'underline' ? 'none' : 'underline';
        }
    };

    window.applyUppercase = function () {
        if (selectedElement) {
            // если уже uppercase, сбрасываем, иначе приводим весь текст к uppercase
            const isUpper = selectedElement.style.textTransform === 'uppercase';
            selectedElement.style.textTransform = isUpper ? 'none' : 'uppercase';
        }
    };

    window.alignToCanvas = function (align) {
        if (!selectedElement || !canvas) return;

        const eW = selectedElement.offsetWidth;
        const eH = selectedElement.offsetHeight;
        const cW = canvas.clientWidth;
        const cH = canvas.clientHeight;

        // Безопасные отступы (как в CSS линий)
        const safeMargin = 10;

        let left = parseFloat(selectedElement.style.left) || selectedElement.offsetLeft;
        let top = parseFloat(selectedElement.style.top) || selectedElement.offsetTop;

        switch (align) {
            // По краям холста
            case 'left':
                left = 0;
                break;
            case 'center':
                left = (cW - eW) / 2;
                break;
            case 'right':
                left = cW - eW;
                break;

            case 'top':
                top = 0;
                break;
            case 'middle':
                top = (cH - eH) / 2;
                break;
            case 'bottom':
                top = cH - eH;
                break;

            // По линиям безопасности
            case 'safe-left':
                left = safeMargin;
                break;
            case 'safe-right':
                left = cW - eW - safeMargin;
                break;
            case 'safe-top':
                top = safeMargin;
                break;
            case 'safe-bottom':
                top = cH - eH - safeMargin;
                break;
        }

        selectedElement.style.left = `${left}px`;
        selectedElement.style.top = `${top}px`;
    };

    window.onLetterSpacingChange = function () {
        if (!selectedElement) return;
        const val = document.getElementById('letterSpacingInput').value;
        selectedElement.style.letterSpacing = `${val}px`;
        if (typeof saveState === 'function') saveState();
    };

    window.onLineHeightChange = function () {
        if (!selectedElement) return;
        const val = document.getElementById('lineHeightInput').value;
        selectedElement.style.lineHeight = val;
        if (typeof saveState === 'function') saveState();
    };

    window.onOpacityChange = function () {
        if (!selectedElement) return;
        const val = document.getElementById('opacityInput').value;
        selectedElement.style.opacity = val;
        if (typeof saveState === 'function') saveState();
    };


    // ВЫРАВНИЫВНИЕ ВНУТРИ ТЕКСТОВОГО БЛОКА
    // список возможных выравниваний и соответствующие иконки
    const ALIGN_MODES = [
        { mode: 'left', icon: '⯇' },
        { mode: 'center', icon: '↔' },
        { mode: 'right', icon: '⯈' },
    ];

    // ВЫРАВНИВАНИЕ ВНУТРИ ТЕКСТОВОГО БЛОКА
    window.alignText = function (align) {
        if (!selectedElement) return;
        selectedElement.style.textAlign = align;
    };

    window.toggleAlign = function () {
        if (!selectedElement) return;

        // получаем текущее
        const current = selectedElement.style.textAlign || 'left';
        // находим индекс в массиве (если нет — 0)
        let idx = ALIGN_MODES.findIndex(a => a.mode === current);
        if (idx < 0) idx = 0;

        // следующий (с циклом)
        const next = ALIGN_MODES[(idx + 1) % ALIGN_MODES.length];

        // устанавливаем на элемент
        alignText(next.mode);

        // меняем иконку кнопки
        const btn = document.getElementById('alignBtn');
        if (btn) btn.textContent = next.icon;
    };

    window.toggleLockElement = function () {
        if (!selectedElement) return;

        const btn = document.getElementById('lockElement');
        const isLocked = selectedElement.classList.toggle('locked');

        // Блокировка перетаскивания
        if (isLocked) {
            selectedElement.removeAttribute('draggable');
            btn.textContent = '🔓';   // или любой другой значок «разблокировать»
            btn.title = 'Разблокировать';
        } else {
            selectedElement.setAttribute('draggable', 'true');
            btn.textContent = '🔒';
            btn.title = 'Фиксировать';
        }
    };

    // ——— Копирование элемента ———
    window.copyElement = function () {
        if (!selectedElement) return;

        // Клонируем сам элемент и его resize-хэндлы (если есть)
        const clone = selectedElement.cloneNode(true);
        // Увеличиваем z-index, чтобы клон оказался сверху
        const z = parseInt(selectedElement.style.zIndex || 1) + 1;
        clone.style.zIndex = z;
        // Немного смещаем копию, чтобы было видно — например, вправо-вниз на 10px
        const left = (parseFloat(selectedElement.style.left) || 0) + 10;
        const top = (parseFloat(selectedElement.style.top) || 0) + 10;
        clone.style.left = `${left}px`;
        clone.style.top = `${top}px`;

        // Если это text-element, снимем режим редактирования и скроем ручки у клона
        clone.classList.remove('selected');
        clone.removeAttribute('data-editing');
        clone.contentEditable = false;
        clone.style.userSelect = 'none';
        clone.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');

        // Вставляем на холст
        document.getElementById('canvas').appendChild(clone);

        // Привязываем те же обработчики перетаскивания/ресайза, что и для оригинала
        makeElementDraggable(clone);

        // Сбрасываем текущее выделение и выделяем новый клон
        if (selectedElement) {
            selectedElement.classList.remove('selected');
            selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
        }
        selectedElement = clone;
        selectedElement.classList.add('selected');
        selectedElement.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'block');

        // Показываем панель редактирования под клон
        if (clone.classList.contains('text-element')) {
            showEditor('text');
            showTextEditPanel(clone);
        } else {
            showEditor('image');
            showImageEditPanel();
        }

        if (typeof saveState === 'function') saveState();
    };

    // ——— Удаление элемента ———
    window.deleteElement = function () {
        if (!selectedElement) return;

        // Удаляем из DOM
        selectedElement.remove();

        // Сбрасываем панель и выделение
        selectedElement = null;
        hideTextEditPanel();
        showEditor('default');

        if (typeof saveState === 'function') saveState();
    };



    // === УДАЛЕНИЕ ЭЛЕМЕНТОВ ===
    document.addEventListener('keydown', (e) => {
        const selEl = selectedElement;
        const isEditing = selEl && selEl.contentEditable === 'true' && document.activeElement === selEl;
        if (!isEditing && (e.key === 'Delete') && selEl) {
            e.preventDefault();
            selEl.remove();
            selectedElement = null;
            hideTextEditPanel();
        }
    });

});


