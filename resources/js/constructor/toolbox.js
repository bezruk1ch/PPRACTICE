// toolbox.js

/**
 * Инициализация панели инструментов
 */
export function initToolbox() {
  const slideToolbox = document.getElementById('slide-toolbox');
  if (!slideToolbox) {
    console.error('Элемент slide-toolbox не найден');
    return;
  }

  // Все секции внутри панели
  const sections = slideToolbox.querySelectorAll('.toolbox-section');
  let currentTool = null;

  // Обработчик клика по инструментам
  document.querySelectorAll('[data-tool]').forEach(button => {
    button.addEventListener('click', e => {
      e.stopPropagation();
      const tool = button.dataset.tool;
      const targetSection = document.getElementById(`${tool}-options`);
      
      if (!targetSection) {
        console.warn(`Секция ${tool}-options не найдена`);
        return;
      }

      // Переключение видимости
      if (slideToolbox.classList.contains('visible') && currentTool === tool) {
        slideToolbox.classList.remove('visible');
        sections.forEach(sec => sec.style.display = 'none');
        currentTool = null;
      } else {
        slideToolbox.classList.add('visible');
        sections.forEach(sec => sec.style.display = 'none');
        targetSection.style.display = 'block';
        currentTool = tool;
      }
    });
  });

  // Кнопка закрытия
  const closeBtn = document.getElementById('closeSlide');
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      slideToolbox.classList.remove('visible');
      sections.forEach(sec => sec.style.display = 'none');
      currentTool = null;
    });
  }

  // Обработка фона
  initBackgroundSection();
  
  // Обработка изображений
  initImagesSection();
}

function initBackgroundSection() {
  const bgSection = document.getElementById('background-options');
  if (!bgSection) return;

  const canvas = document.getElementById('canvas');
  if (!canvas) return;

  // Выбор цвета
  const colorPicker = bgSection.querySelector('.color-picker');
  if (colorPicker) {
    colorPicker.addEventListener('input', e => {
      canvas.style.backgroundImage = 'none';
      canvas.style.backgroundColor = e.target.value;
    });
  }

  // Загрузка фона
  const uploadBg = bgSection.querySelector('.upload-input');
  if (uploadBg) {
    uploadBg.addEventListener('change', e => {
      const file = e.target.files[0];
      if (!file) return;
      
      const reader = new FileReader();
      reader.onload = ev => {
        canvas.style.backgroundImage = `url(${ev.target.result})`;
        canvas.style.backgroundSize = 'cover';
        canvas.style.backgroundPosition = 'center';
        canvas.style.backgroundColor = 'transparent';
      };
      reader.readAsDataURL(file);
    });
  }

  // Фон по URL
  const bgUrlInput = bgSection.querySelector('#bgUrlInput');
  const addBgByUrlBtn = bgSection.querySelector('#addBgByUrlBtn');

  if (addBgByUrlBtn && bgUrlInput) {
    addBgByUrlBtn.addEventListener('click', () => {
      const url = bgUrlInput.value.trim();
      if (!url) {
        alert('Введите ссылку на изображение');
        return;
      }
      
      const img = new Image();
      img.crossOrigin = 'Anonymous';
      img.onload = () => {
        canvas.style.backgroundImage = `url(${url})`;
        canvas.style.backgroundSize = 'cover';
        canvas.style.backgroundPosition = 'center';
        canvas.style.backgroundColor = 'transparent';
        bgUrlInput.value = '';
      };
      img.onerror = () => {
        alert('Не удалось загрузить изображение. Проверьте URL и поддержку CORS.');
      };
      img.src = url;
    });
  }
}

function initImagesSection() {
  const imgSection = document.getElementById('images-options');
  if (!imgSection) {
    console.warn('Секция images-options не найдена');
    return;
  }

  // Загрузка с компьютера
  const uploadBtn = imgSection.querySelector('button[data-action="upload"]');
  const uploadInput = imgSection.querySelector('input.upload-input');
  
  if (uploadBtn && uploadInput) {
    uploadBtn.addEventListener('click', () => uploadInput.click());
    
    uploadInput.addEventListener('change', e => {
      const file = e.target.files?.[0];
      if (!file) return;
      
      const reader = new FileReader();
      reader.onload = ev => {
        // Если функция вставки не определена, создаем базовую
        if (typeof window.insertImageOnCanvas !== 'function') {
          window.insertImageOnCanvas = createDefaultImageInserter();
        }
        window.insertImageOnCanvas(ev.target.result);
      };
      reader.readAsDataURL(file);
    });
  } else {
    console.warn('Элементы загрузки изображений не найдены');
  }

  // Добавление по ссылке
  const urlBtn = imgSection.querySelector('button[data-action="by-url"]');
  const urlInput = imgSection.querySelector('input.text-input');
  
  if (urlBtn && urlInput) {
    const handleImageByUrl = () => {
      const url = urlInput.value.trim();
      if (!url) {
        alert('Введите URL картинки');
        return;
      }
      
      // Проверка URL (более гибкая)
      if (!isValidImageUrl(url)) {
        alert('URL должен указывать на изображение (jpg, png, gif, webp, svg)');
        return;
      }

      // Если функция вставки не определена, создаем базовую
      if (typeof window.insertImageOnCanvas !== 'function') {
        window.insertImageOnCanvas = createDefaultImageInserter();
      }

      const img = new Image();
      img.crossOrigin = 'Anonymous';
      img.onload = () => {
        window.insertImageOnCanvas(url);
        urlInput.value = '';
      };
      img.onerror = () => {
        alert('Ошибка загрузки изображения. Проверьте URL и поддержку CORS.');
      };
      img.src = url;
    };

    urlBtn.addEventListener('click', handleImageByUrl);
    urlInput.addEventListener('keydown', e => {
      if (e.key === 'Enter') handleImageByUrl();
    });
  } else {
    console.warn('Элементы для добавления по URL не найдены');
  }
}

// Вспомогательные функции
function isValidImageUrl(url) {
  return /\.(jpe?g|png|gif|webp|svg)(\?.*)?$/i.test(url);
}

function createDefaultImageInserter() {
  console.warn('Функция insertImageOnCanvas не определена. Используется базовая реализация.');
  
  return function(imageSrc) {
    const canvas = document.getElementById('canvas');
    if (!canvas) {
      console.error('Холст (canvas) не найден');
      return;
    }
    
    const img = document.createElement('img');
    img.src = imageSrc;
    img.classList.add('draggable');
    img.style.position = 'absolute';
    img.style.top = '50px';
    img.style.left = '50px';
    img.style.maxWidth = '200px';
    img.style.maxHeight = '200px';
    img.style.cursor = 'move';
    
    canvas.appendChild(img);
    
    // Базовая реализация перетаскивания
    let isDragging = false;
    let offsetX, offsetY;
    
    img.addEventListener('mousedown', e => {
      isDragging = true;
      offsetX = e.clientX - img.getBoundingClientRect().left;
      offsetY = e.clientY - img.getBoundingClientRect().top;
      img.style.zIndex = '1000';
    });
    
    document.addEventListener('mousemove', e => {
      if (!isDragging) return;
      
      const canvasRect = canvas.getBoundingClientRect();
      const x = e.clientX - canvasRect.left - offsetX;
      const y = e.clientY - canvasRect.top - offsetY;
      
      // Ограничение перемещения в пределах холста
      img.style.left = `${Math.max(0, Math.min(x, canvasRect.width - img.offsetWidth))}px`;
      img.style.top = `${Math.max(0, Math.min(y, canvasRect.height - img.offsetHeight))}px`;
    });
    
    document.addEventListener('mouseup', () => {
      isDragging = false;
      img.style.zIndex = '1';
    });
  };
}

// ===== constructor.js ===== //

// Функция применения шаблона
function applyCanvasTemplate(template) {
  const canvas = document.getElementById('canvas');
  const wrapper = document.getElementById('canvas-wrapper');
  
  if (!canvas || !wrapper) {
    console.error('Canvas или wrapper не найдены');
    return;
  }

  // Сохраняем позицию скролла
  const prevScroll = { left: wrapper.scrollLeft, top: wrapper.scrollTop };
  
  clearCanvas();
  
  // Применяем размеры
  canvas.style.width = `${template.width}px`;
  canvas.style.height = `${template.height}px`;
  
  // Фоновое изображение
  if (template.image) {
    canvas.style.backgroundImage = `url('${template.image}')`;
    canvas.style.backgroundSize = 'cover';
    canvas.style.backgroundPosition = 'center';
  } else {
    canvas.style.backgroundImage = '';
    canvas.style.backgroundColor = '#ffffff';
  }
  
  // Восстанавливаем скролл
  requestAnimationFrame(() => wrapper.scrollTo(prevScroll.left, prevScroll.top));
  
  // Обновляем направляющие
  updateSafetyLines(template.width, template.height);
  
  // Направляющие для буклета
  if (template.type === 'Буклет') {
    drawBookletGuides(template.width);
  } else {
    clearBookletGuides();
  }
}

function drawBookletGuides(width) {
  const canvas = document.getElementById('canvas');
  if (!canvas) return;
  
  // Удаляем старые направляющие
  clearBookletGuides();
  
  const third = width / 3;
  for (let i = 1; i <= 2; i++) {
    const guide = document.createElement('div');
    guide.classList.add('booklet-guide');
    guide.style.cssText = `
      position: absolute;
      top: 0;
      bottom: 0;
      width: 1px;
      background: repeating-linear-gradient(
        to bottom,
        #ccc,
        #ccc 10px,
        transparent 10px,
        transparent 20px
      );
      left: ${i * third}px;
      z-index: 50;
    `;
    canvas.appendChild(guide);
  }
}

function clearBookletGuides() {
  const guides = document.querySelectorAll('#canvas .booklet-guide');
  guides.forEach(guide => guide.remove());
}

function clearCanvas() {
  const canvas = document.getElementById('canvas');
  if (!canvas) return;
  
  // Удаляем все элементы, кроме фона и направляющих
  const elements = canvas.querySelectorAll(':not(.safety-line, .booklet-guide)');
  elements.forEach(el => el.remove());
}

function updateSafetyLines(width, height) {
  const offset = 20;
  const lines = document.querySelectorAll('.safety-line');
  
  lines.forEach(line => {
    if (line.classList.contains('top')) line.style.top = `${offset}px`;
    if (line.classList.contains('right')) line.style.right = `${offset}px`;
    if (line.classList.contains('bottom')) line.style.bottom = `${offset}px`;
    if (line.classList.contains('left')) line.style.left = `${offset}px`;
  });
}

// Инициализация основ
document.addEventListener('DOMContentLoaded', () => {
  // Восстановление шаблона
  const savedTemplate = sessionStorage.getItem('selectedTemplate');
  if (savedTemplate) {
    try {
      applyCanvasTemplate(JSON.parse(savedTemplate));
    } catch (e) {
      console.error('Ошибка восстановления шаблона:', e);
    }
  }

  // Обработчики выбора основы
  document.querySelectorAll('[data-product-type]').forEach(btn => {
    btn.addEventListener('click', function() {
      const template = {
        type: this.dataset.productType,
        width: parseInt(this.dataset.templateWidth) || 800,
        height: parseInt(this.dataset.templateHeight) || 600,
        image: this.dataset.templateImage || ''
      };
      
      applyCanvasTemplate(template);
      sessionStorage.setItem('selectedTemplate', JSON.stringify(template));
    });
  });
});