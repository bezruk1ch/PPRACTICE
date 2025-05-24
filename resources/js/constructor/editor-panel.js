export function showEditor(type) {
    const editorControls = document.getElementById('editor-controls');
    editorControls.innerHTML = '';

    const title = document.createElement('div');
    title.className = 'editor-title';

    if (type === 'text') {
        title.textContent = 'Редактирование текста';
        editorControls.appendChild(title);
        editorControls.appendChild(
            document.getElementById('tpl-actions-text').content.cloneNode(true)
        );
        window.showTextEditPanel();

    } else if (type === 'image') {
        title.textContent = 'Редактирование изображения';
        editorControls.appendChild(title);
        editorControls.appendChild(
            document.getElementById('tpl-actions-image').content.cloneNode(true)
        );
        window.showImageEditPanel?.(); // если функция пока не реализована, не вызовет ошибку

    } else {
        title.textContent = 'Конструктор заказов онлайн';
        editorControls.appendChild(title);
    }

    // Добавляем базовые действия
    const defTpl = document.getElementById('tpl-actions-default');
    editorControls.appendChild(defTpl.content.cloneNode(true));
}

// при инициализации можно экспортировать и дефолтный вызов
export function initEditorPanel() {
    showEditor('default');
}
