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
  // constructor.js

  // Функция применения шаблона
  function applyCanvasTemplate(template) {
    const canvas = document.getElementById('canvas');
    const wrapper = document.getElementById('canvas-wrapper');

    // Сохраняем пропорции интерфейса
    const prevScroll = {
      left: wrapper.scrollLeft,
      top: wrapper.scrollTop
    };

    // Применяем новые размеры
    canvas.style.width = `${template.width}px`;
    canvas.style.height = `${template.height}px`;

    // Фоновое изображение
    canvas.style.backgroundImage = template.image
      ? `url('${template.image}')`
      : '';

    // Восстанавливаем позицию скролла
    requestAnimationFrame(() => {
      wrapper.scrollTo(prevScroll.left, prevScroll.top);
    });

    // Обновляем направляющие
    updateSafetyLines(template.width, template.height);
  }

  // Функция обновления направляющих
  function updateSafetyLines(width, height) {
    const offset = 20;
    document.querySelectorAll('.safety-line').forEach(line => {
      line.style.display = 'block';
      if (line.classList.contains('top')) line.style.top = `${offset}px`;
      if (line.classList.contains('right')) line.style.right = `${offset}px`;
      if (line.classList.contains('bottom')) line.style.bottom = `${offset}px`;
      if (line.classList.contains('left')) line.style.left = `${offset}px`;
    });
  }

  // Обработчик выбора основы
  document.querySelectorAll('[data-product-type]').forEach(btn => {
    btn.addEventListener('click', function () {
      const template = {
        type: this.dataset.productType,
        width: parseInt(this.dataset.templateWidth),
        height: parseInt(this.dataset.templateHeight),
        image: this.dataset.templateImage
      };

      applyCanvasTemplate(template);
      sessionStorage.setItem('selectedTemplate', JSON.stringify(template));
    });
  });

  // Восстановление при загрузке
  document.addEventListener('DOMContentLoaded', () => {
    const savedTemplate = sessionStorage.getItem('selectedTemplate');
    if (savedTemplate) {
      applyCanvasTemplate(JSON.parse(savedTemplate));
    }
  });


}
