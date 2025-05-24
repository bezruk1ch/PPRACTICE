// image-editor-panel.js
export function initImageEditorPanel() {

  function showImageEditPanel() {
    const el = window.selectedElement;
    if (!el || !el.classList.contains('image-element')) return;

    // Если панель не вставлена - вставляем из шаблона
    if (!document.querySelector('.image-edit-panel')) {
      const tpl = document.getElementById('tpl-actions-image');
      document.querySelector('.editor-bar').appendChild(tpl.content.cloneNode(true));
    }

    const panel = document.querySelector('.image-edit-panel');
    panel.style.display = 'flex';

    // Заполняем текущие значения
    const widthInput = panel.querySelector('#imgWidthInput');
    const rotateInput = panel.querySelector('#imgRotateInput');

    widthInput.value = parseInt(el.style.width) || el.naturalWidth || 100;
    rotateInput.value = getRotation(el) || 0;
  }

  function hideImageEditPanel() {
    const panel = document.querySelector('.image-edit-panel');
    if (panel) panel.style.display = 'none';
  }

  // Получаем угол поворота в градусах из transform: rotate(...)
  function getRotation(el) {
    const st = window.getComputedStyle(el);
    const tr = st.getPropertyValue("transform");
    if (tr === 'none') return 0;
    const values = tr.match(/matrix\((.+)\)/)[1].split(', ');
    const a = parseFloat(values[0]);
    const b = parseFloat(values[1]);
    return Math.round(Math.atan2(b, a) * (180 / Math.PI));
  }

  // Функции для кнопок и инпутов
  window.bringForward = function () {
    const el = window.selectedElement;
    if (!el) return;
    const z = parseInt(el.style.zIndex) || 0;
    el.style.zIndex = z + 1;
  };

  window.sendBackward = function () {
    const el = window.selectedElement;
    if (!el) return;
    const z = parseInt(el.style.zIndex) || 0;
    if (z > 0) el.style.zIndex = z - 1;
  };

  window.onImageWidthChange = function () {
    const el = window.selectedElement;
    if (!el) return;
    const val = document.getElementById('imgWidthInput').value;
    el.style.width = val + 'px';
  };

  window.onImageRotateChange = function () {
    const el = window.selectedElement;
    if (!el) return;
    const val = document.getElementById('imgRotateInput').value;
    el.style.transform = `rotate(${val}deg)`;
  };

  window.deleteElement = function () {
    const el = window.selectedElement;
    if (!el) return;
    el.remove();
    window.selectedElement = null;
    hideImageEditPanel();
  };

  // Экспортируем функции показа и скрытия панели
  window.showImageEditPanel = showImageEditPanel;
  window.hideImageEditPanel = hideImageEditPanel;
}
