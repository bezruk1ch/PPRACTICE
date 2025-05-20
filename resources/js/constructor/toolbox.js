// toolbox.js

/**
 * Инициализация панели инструментов (слайдбокс слева)
 */
export function initToolbox() {
  const slideToolbox = document.getElementById('slide-toolbox');
  if (!slideToolbox) return;

  // Все секции внутри панели
  const sections = slideToolbox.querySelectorAll('.toolbox-section');

  // Текущий активный инструмент
  let currentTool = null;

  // Обработчик клика по кнопкам инструментов
  document.querySelectorAll('[data-tool]').forEach(button => {
    button.addEventListener('click', e => {
      e.stopPropagation();
      const tool = button.dataset.tool;
      const targetSection = document.getElementById(`${tool}-options`);
      if (!targetSection) return;

      // Если та же кнопка — закрываем
      if (
        slideToolbox.classList.contains('visible') &&
        currentTool === tool
      ) {
        slideToolbox.classList.remove('visible');
        sections.forEach(sec => (sec.style.display = 'none'));
        currentTool = null;
        return;
      }

      // Открываем нужную секцию
      slideToolbox.classList.add('visible');
      sections.forEach(sec => (sec.style.display = 'none'));
      targetSection.style.display = 'block';
      currentTool = tool;
    });
  });

  // Кнопка крестика закрытия панели
  const closeBtn = document.getElementById('closeSlide');
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      slideToolbox.classList.remove('visible');
      sections.forEach(sec => (sec.style.display = 'none'));
      currentTool = null;
    });
  }

  // Функционал вкладки "Фон"
  const bgSection = document.getElementById('background-options');
  if (bgSection) {
    // Заливка цветом
    const colorPicker = bgSection.querySelector('.color-picker');
    if (colorPicker) {
      colorPicker.addEventListener('input', e => {
        document.getElementById('canvas').style.backgroundColor = e.target.value;
      });
    }
    // Загрузка изображения-фона
    const uploadBg = bgSection.querySelector('.upload-input');
    if (uploadBg) {
      uploadBg.addEventListener('change', e => {
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
    }
  }

  // Функционал вкладки "Картинки"
  const imgSection = document.getElementById('images-options');
  if (imgSection) {
    const uploadImg = imgSection.querySelector('.upload-input');
    if (uploadImg) {
      uploadImg.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => insertImageOnCanvas(ev.target.result);
        reader.readAsDataURL(file);
      });
    }
    const addByUrlBtn = document.getElementById('addByUrlBtn');
    const urlInput = document.getElementById('urlInput');
    if (addByUrlBtn && urlInput) {
      addByUrlBtn.addEventListener('click', () => {
        const url = urlInput.value.trim();
        if (url) {
          insertImageOnCanvas(url);
          urlInput.value = '';
        }
      });
      urlInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') addByUrlBtn.click();
      });
    }
  }

  // Функционал вкладки "Основа"
  const baseSection = document.getElementById('base-options');
  if (baseSection) {
    const typeMap = {
      'Визитка': 'business-card',
      'Футболка': 'tshirt',
      'Постер': 'poster',
      'Буклет': 'brochure'
    };
    baseSection.querySelectorAll('.tool-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const key = btn.textContent.trim();
        const type = typeMap[key] || 'custom';
        setCanvasTemplate(type);
      });
    });
  }

  /**
   * Вставляет изображение на холст и делает его перетаскиваемым
   */
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

  /**
   * Устанавливает шаблон холста (основа)
   */
  function setCanvasTemplate(type) {
    const canvas = document.getElementById('canvas');
    canvas.classList.remove('tpl-tshirt', 'tpl-poster', 'tpl-business-card', 'tpl-brochure');
    canvas.classList.add(`tpl-${type}`);
    canvas.style.background = '';
    canvas.style.width = '';
    canvas.style.height = '';

    if (type === 'tshirt') {
      canvas.style.background = "url('/img/constructor/tshirt.png') no-repeat center/contain";
      canvas.style.width = '800px';
      canvas.style.height = '850px';
    }
  }
}
