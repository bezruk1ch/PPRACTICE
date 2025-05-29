// text-editor-panel.js
// Модуль: Панель редактирования текста с привязкой через addEventListener вместо inline-атрибутов

/**
 * Инициализация панели редактирования текста и привязка событий
 * Вызывается после загрузки DOM, затем в showTextEditPanel
 */
export function initTextEditorPanel() {
  // Конвертация цвета из rgb() в hex
  function rgbToHex(rgb) {
    const result = rgb.match(/\d+/g);
    return result ? '#' + result.map(x => (+x).toString(16).padStart(2, '0')).join('') : '#000000';
  }

  // Показывает панель редактирования текста
  function showTextEditPanel() {
    const el = window.selectedElement;
    if (!el || !el.classList.contains('text-element')) return;
    if (!document.querySelector('.text-edit-panel')) {
      const tpl = document.getElementById('tpl-actions-text');
      document.querySelector('.editor-bar').appendChild(tpl.content.cloneNode(true));
    }
    const panel = document.querySelector('.text-edit-panel');
    panel.style.display = 'flex';

    // Заполнение контролов текущими значениями
    panel.querySelector('#fontSelect').value = el.style.fontFamily || 'Arial';
    panel.querySelector('#fontSizeInput').value = parseInt(el.style.fontSize) || 16;
    panel.querySelector('#fontColorInput').value = rgbToHex(getComputedStyle(el).color);
    panel.querySelector('#letterSpacingInput').value = parseFloat(el.style.letterSpacing) || 0;
    panel.querySelector('#lineHeightInput').value = el.style.lineHeight || 'normal';
    panel.querySelector('#opacityInput').value = parseFloat(el.style.opacity) || 1;

    bindTextPanelEvents(panel);
  }

  // Скрывает панель редактирования текста
  function hideTextEditPanel() {
    const panel = document.querySelector('.text-edit-panel');
    if (panel) panel.style.display = 'none';
  }

  // Навешивает события на элементы панели редактирования
  function bindTextPanelEvents(panel) {
    const el = window.selectedElement;
    if (!el) return;

    // font family change
    panel.querySelector('#fontSelect').onchange = () => {
      el.style.fontFamily = panel.querySelector('#fontSelect').value;
      saveState?.();
    };

    // font size change
    panel.querySelector('#fontSizeInput').onchange = () => {
      el.style.fontSize = `${panel.querySelector('#fontSizeInput').value}px`;
      saveState?.();
    };

    // font color change
    panel.querySelector('#fontColorInput').onchange = () => {
      el.style.color = panel.querySelector('#fontColorInput').value;
      saveState?.();
    };

    // letter spacing
    panel.querySelector('#letterSpacingInput').oninput = () => {
      el.style.letterSpacing = `${panel.querySelector('#letterSpacingInput').value}px`;
      saveState?.();
    };

    // line height
    panel.querySelector('#lineHeightInput').oninput = () => {
      el.style.lineHeight = panel.querySelector('#lineHeightInput').value;
      saveState?.();
    };

    // opacity
    panel.querySelector('#opacityInput').oninput = () => {
      el.style.opacity = panel.querySelector('#opacityInput').value;
      saveState?.();
    };

    // bold
    window.applyBold = () => {
      const isBold = getComputedStyle(el).fontWeight === '700';
      el.style.fontWeight = isBold ? 'normal' : 'bold';
      saveState?.();
    };

    // italic
    window.applyItalic = () => {
      const isItalic = getComputedStyle(el).fontStyle === 'italic';
      el.style.fontStyle = isItalic ? 'normal' : 'italic';
      saveState?.();
    };

    // underline
    window.applyUnderline = () => {
      const under = getComputedStyle(el).textDecorationLine.includes('underline');
      el.style.textDecoration = under ? 'none' : 'underline';
      saveState?.();
    };

    // uppercase
    window.applyUppercase = () => {
      const isUpper = getComputedStyle(el).textTransform === 'uppercase';
      el.style.textTransform = isUpper ? 'none' : 'uppercase';
      saveState?.();
    };

    // toggle align
    window.toggleAlign = () => {
      const modes = ['left', 'center', 'right'];
      const current = el.style.textAlign || 'left';
      const next = modes[(modes.indexOf(current) + 1) % modes.length];
      el.style.textAlign = next;
      const btn = document.getElementById('alignBtn');
      if (btn) btn.textContent = next === 'left' ? '⬅️' : next === 'center' ? '↔️' : '➡️';
      saveState?.();
    };

    // bring/send layers
    window.bringForward = () => {
      el.style.zIndex = (parseInt(el.style.zIndex || 1) + 1);
      saveState?.();
    };

    window.sendBackward = () => {
      let z = parseInt(el.style.zIndex || 1);
      if (z > 1) el.style.zIndex = z - 1;
      saveState?.();
    };

    // align to canvas
    window.alignToCanvas = (mode) => {
      const canvas = document.getElementById('canvas');
      const eW = el.offsetWidth;
      const eH = el.offsetHeight;
      const cW = canvas.clientWidth;
      const cH = canvas.clientHeight;
      const safe = 10;
      let left = parseFloat(el.style.left) || el.offsetLeft;
      let top = parseFloat(el.style.top) || el.offsetTop;

      switch (mode) {
        case 'left': left = 0; break;
        case 'center': left = (cW - eW) / 2; break;
        case 'right': left = cW - eW; break;
        case 'top': top = 0; break;
        case 'middle': top = (cH - eH) / 2; break;
        case 'bottom': top = cH - eH; break;
        case 'safe-left': left = safe; break;
        case 'safe-right': left = cW - eW - safe; break;
        case 'safe-top': top = safe; break;
        case 'safe-bottom': top = cH - eH - safe; break;
      }

      el.style.left = `${left}px`;
      el.style.top = `${top}px`;
      saveState?.();
    };

    // lock toggle
    window.toggleLockElement = () => {
      const btn = panel.querySelector('#lockElement');
      const isLocked = el.classList.toggle('locked');
      if (isLocked) el.removeAttribute('draggable'), btn.textContent = '🔓';
      else el.setAttribute('draggable', 'true'), btn.textContent = '🔒';
    };

    // copy & delete
    window.copyElement = () => {

      const el = window.selectedElement;
      if (!el) return;

      const clone = el.cloneNode(true);
      const canvas = document.getElementById('canvas');
      clone.style.zIndex = (parseInt(el.style.zIndex || 1) + 1);
      clone.style.left = `${(parseFloat(el.style.left) || 0) + 10}px`;
      clone.style.top = `${(parseFloat(el.style.top) || 0) + 10}px`;
      clone.classList.remove('selected');
      clone.removeAttribute('data-editing');
      clone.contentEditable = false;
      clone.style.userSelect = 'none';
      clone.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
      canvas.appendChild(clone);
      makeElementDraggable(clone);
      el.classList.remove('selected');
      el.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'none');
      window.selectedElement = clone;
      clone.classList.add('selected');
      clone.querySelectorAll('.resize-handle').forEach(h => h.style.display = 'block');
      showEditor('text');
      showTextEditPanel();
      saveState?.();
    };

    window.deleteElement = () => {
      el.remove();
      window.selectedElement = null;
      hideTextEditPanel();
      showEditor('default');
      saveState?.();
    };
  }
  

  // Привязываем глобальные функции управления панелью
  window.showTextEditPanel = showTextEditPanel;
  window.hideTextEditPanel = hideTextEditPanel;
  window.rgbToHex = rgbToHex;


}
