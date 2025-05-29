// modals.js
// ====== МОДАЛЬНЫЕ ОКНА ======

/**
 * Инициализирует модальные окна проверки макета и ввода названия проекта
 * @param {HTMLElement} proceedBtn - Кнопка "Продолжить", открывающая модалку
 */
/**
 * Инициализирует модальные окна проверки макета и ввода названия проекта
 * @param {HTMLElement} proceedBtn - Кнопка "Продолжить", открывающая модалку
 */
export function initPreviewModal(proceedBtn) {
  const previewModal = document.getElementById('preview-modal');
  const projectNameModal = document.getElementById('projectNameModal');

  if (!previewModal || !proceedBtn || !projectNameModal) return;

  // Элементы управления
  const previewBtns = previewModal.querySelectorAll('.preview-buttons .btn');
  const closePreviewBtn = document.getElementById('closePreviewModal');
  const closeProjectNameBtn = projectNameModal.querySelector('.close-project-modal');
  const cancelProjectNameBtn = projectNameModal.querySelector('.cancel-btn');
  const confirmProjectNameBtn = projectNameModal.querySelector('.confirm-btn');
  const projectNameInput = document.getElementById('projectNameInput');

  // Состояния модальных окон
  let isProjectNameModalOpen = false;

  // ====== ФУНКЦИИ ДЛЯ РАБОТЫ С МОДАЛКАМИ ======

  const togglePreviewModal = (show) => {
    previewModal.style.display = show ? 'flex' : 'none';
  };

  const toggleProjectNameModal = (show) => {
    projectNameModal.style.display = show ? 'flex' : 'none';
    isProjectNameModalOpen = show;
  };

  const resetProjectNameInput = () => {
    projectNameInput.value = '';
    projectNameInput.placeholder = 'Без названия';
  };

  // Функция для загрузки изображения с CORS
  const loadImageWithCORS = (url) => {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.crossOrigin = 'Anonymous';
      
      img.onload = () => resolve(img);
      img.onerror = () => {
        // Пробуем использовать CORS-прокси если прямой доступ не работает
        const proxyUrl = `https://cors-anywhere.herokuapp.com/${url}`;
        const proxyImg = new Image();
        proxyImg.crossOrigin = 'Anonymous';
        proxyImg.onload = () => resolve(proxyImg);
        proxyImg.onerror = reject;
        proxyImg.src = proxyUrl;
      };
      
      img.src = url;
    });
  };

  // Подготовка canvas к рендерингу
  const prepareCanvasForRender = async () => {
    const canvasElement = document.getElementById('canvas');
    if (!canvasElement) return [];

    // Заменить все изображения на загруженные с CORS
    const images = Array.from(canvasElement.querySelectorAll('img'));
    const replacedImages = [];
    
    for (const img of images) {
      if (img.src.startsWith('data:')) continue;
      
      try {
        const loadedImg = await loadImageWithCORS(img.src);
        const newImg = img.cloneNode();
        newImg.src = loadedImg.src;
        newImg.crossOrigin = 'Anonymous';
        img.parentNode.replaceChild(newImg, img);
        replacedImages.push({ original: img, replacement: newImg });
      } catch (error) {
        console.warn('Не удалось загрузить изображение с CORS:', img.src);
        img.crossOrigin = 'Anonymous';
      }
    }

    // Дождаться загрузки всех изображений
    await Promise.all(
      Array.from(canvasElement.querySelectorAll('img')).map(img => {
        if (img.complete) return Promise.resolve();
        
        return new Promise(resolve => {
          img.onload = resolve;
          img.onerror = resolve;
        });
      })
    );

    return replacedImages;
  };

  // Восстановление оригинальных изображений
  const restoreCanvasState = (replacedImages) => {
    replacedImages.forEach(({ original, replacement }) => {
      if (replacement.parentNode) {
        replacement.parentNode.replaceChild(original, replacement);
      }
    });
  };

  // Создание превью проекта
  const createProjectPreview = async () => {
    const replacedImages = await prepareCanvasForRender();
    
    try {
      const canvas = await window.html2canvas(document.getElementById('canvas'), {
        useCORS: true,
        scale: 1,
        logging: false,
        backgroundColor: '#ffffff',
        allowTaint: true,
        foreignObjectRendering: false
      });
      
      return canvas.toDataURL('image/png');
    } finally {
      restoreCanvasState(replacedImages);
    }
  };

  // ====== ОБРАБОТЧИКИ СОБЫТИЙ ======

  // Открытие главной модалки проверки
  proceedBtn.addEventListener('click', (e) => {
    e.preventDefault();
    togglePreviewModal(true);
  });

  // Обработка действий в модалке проверки
  previewBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const action = btn.dataset.action;

      switch (action) {
        case 'front':
          document.getElementById('frontSideBtn')?.click();
          break;
        case 'back':
          document.getElementById('backSideBtn')?.click();
          break;
        case 'order':
          togglePreviewModal(false);
          toggleProjectNameModal(true);
          break;
        case 'download':
          document.querySelector('.download-btn')?.click();
          break;
        case 'edit':
          togglePreviewModal(false);
          break;
      }
    });
  });

  // Сохранение проекта в корзину
  confirmProjectNameBtn.addEventListener('click', async () => {
    const projectName = projectNameInput.value.trim() || 'Без названия';
    const selectedTemplate = sessionStorage.getItem('selectedTemplate');
    
    if (!selectedTemplate) {
      alert('Пожалуйста, выберите основу перед оформлением заказа.');
      return;
    }

    // Показать лоадер
    const loader = document.createElement('div');
    loader.className = 'order-loader';
    loader.innerHTML = 'Подготовка проекта...';
    projectNameModal.appendChild(loader);

    try {
      // Создаем превью
      const preview = await createProjectPreview();
      
      // Формируем данные для отправки
      const payload = {
        project_name: projectName,
        project_data: JSON.stringify({
          template: JSON.parse(selectedTemplate),
          preview,
          date: new Date().toISOString()
        })
      };

      // Отправляем на сервер
      const response = await fetch('/cart/add', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      const result = await response.json();

      if (result.success) {
        window.location.href = '/cart';
      } else {
        alert(result.message || 'Ошибка при добавлении в корзину.');
      }
    } catch (error) {
      console.error('Ошибка при оформлении заказа:', error);
      alert('Произошла ошибка при отправке проекта.');
    } finally {
      loader.remove();
    }
  });

  // Закрытие модалок
  const handleClosePreview = () => togglePreviewModal(false);
  const handleCloseProjectName = () => {
    toggleProjectNameModal(false);
    togglePreviewModal(true);
    resetProjectNameInput();
  };

  // Навешиваем обработчики закрытия
  closePreviewBtn?.addEventListener('click', handleClosePreview);
  closeProjectNameBtn?.addEventListener('click', handleCloseProjectName);
  cancelProjectNameBtn?.addEventListener('click', handleCloseProjectName);

  // Закрытие по клику вне модалки
  const handleOutsideClick = (e, modal, closeHandler) => {
    if (e.target === modal) closeHandler();
  };

  previewModal.addEventListener('click', (e) =>
    handleOutsideClick(e, previewModal, handleClosePreview));

  projectNameModal.addEventListener('click', (e) =>
    handleOutsideClick(e, projectNameModal, handleCloseProjectName));

  // Закрытие по ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (isProjectNameModalOpen) {
        handleCloseProjectName();
      } else if (previewModal.style.display === 'flex') {
        handleClosePreview();
      }
    }
  });

  // Сброс данных при закрытии страницы
  window.addEventListener('beforeunload', () => {
    sessionStorage.removeItem('currentProjectName');
  });
}

// Инициализация модалки названия проекта
export function initProjectNameModal() {
  const projectName = sessionStorage.getItem('currentProjectName');
  if (projectName) {
    document.getElementById('projectNameInput').value = projectName;
  }
}

// ====== МОДАЛЬНОЕ ОКНО "СКАЧАТЬ МАКЕТ" ======

/**
 * Инициализирует модальное окно скачивания макета
 * @param {HTMLElement} downloadBtn - Кнопка "Скачать макет"
 * @param {HTMLElement} closeDownloadBtn - Кнопка "×" закрытия модалки
 * @param {HTMLElement} downloadJPGBtn - Кнопка "JPG"
 * @param {HTMLElement} downloadPDFBtn - Кнопка "PDF"
 */
export function initDownloadModal(downloadBtn, closeDownloadBtn, downloadJPGBtn, downloadPDFBtn) {
  const downloadModal = document.getElementById('downloadModal');
  const canvasElement = document.getElementById('canvas');

  if (!downloadModal || !downloadBtn || !closeDownloadBtn || !downloadJPGBtn || !downloadPDFBtn || !canvasElement) {
    console.error('Один из элементов для скачивания не найден');
    return;
  }

  // Функция для загрузки изображения с проксированием CORS
  const loadImageWithCORS = (url) => {
    return new Promise((resolve, reject) => {
      const img = new Image();
      img.crossOrigin = 'Anonymous';

      img.onload = () => resolve(img);
      img.onerror = () => {
        // Пробуем использовать CORS-прокси если прямой доступ не работает
        const proxyUrl = `https://cors-anywhere.herokuapp.com/${url}`;
        const proxyImg = new Image();
        proxyImg.crossOrigin = 'Anonymous';
        proxyImg.onload = () => resolve(proxyImg);
        proxyImg.onerror = reject;
        proxyImg.src = proxyUrl;
      };

      img.src = url;
    });
  };

  // Функция для подготовки canvas к рендерингу
  const prepareCanvasForRender = async () => {
    // Показать все временные элементы
    document.querySelectorAll('.temp-element').forEach(el => {
      el.style.visibility = 'visible';
    });

    // Заменить все изображения на загруженные с CORS
    const images = Array.from(canvasElement.querySelectorAll('img'));
    const replacedImages = [];

    for (const img of images) {
      if (img.src.startsWith('data:')) continue; // Пропускаем DataURL

      try {
        const loadedImg = await loadImageWithCORS(img.src);
        const newImg = img.cloneNode();
        newImg.src = loadedImg.src;
        newImg.crossOrigin = 'Anonymous';
        img.parentNode.replaceChild(newImg, img);
        replacedImages.push({ original: img, replacement: newImg });
      } catch (error) {
        console.warn('Не удалось загрузить изображение с CORS:', img.src);
        // Оставляем оригинальное изображение
        img.crossOrigin = 'Anonymous';
      }
    }

    // Убедиться, что все изображения загружены
    await Promise.all(
      Array.from(canvasElement.querySelectorAll('img')).map(img => {
        if (img.complete) return Promise.resolve();

        return new Promise(resolve => {
          img.onload = resolve;
          img.onerror = resolve; // Продолжить даже если ошибка
        });
      })
    );

    return replacedImages; // Возвращаем информацию о замененных изображениях
  };

  // Восстановление состояния после рендеринга
  const restoreCanvasState = (replacedImages) => {
    // Восстановить оригинальные изображения
    replacedImages.forEach(({ original, replacement }) => {
      if (replacement.parentNode) {
        replacement.parentNode.replaceChild(original, replacement);
      }
    });

    // Скрыть временные элементы
    document.querySelectorAll('.temp-element').forEach(el => {
      el.style.visibility = 'hidden';
    });
  };

  // Общая функция скачивания
  const downloadHandler = async (type) => {
    // Показать индикатор загрузки
    const loader = document.getElementById('downloadLoader');
    if (loader) loader.style.display = 'block';

    let replacedImages = [];

    try {
      // Подготовка canvas
      replacedImages = await prepareCanvasForRender();

      // Создаем canvas с html2canvas
      const canvas = await window.html2canvas(canvasElement, {
        useCORS: true,
        scale: 2,
        logging: true, // Включим логирование для отладки
        backgroundColor: '#ffffff',
        allowTaint: true, // Разрешаем "загрязненные" canvas
        foreignObjectRendering: false, // Альтернативный рендеринг
        onclone: (clonedDoc) => {
          // Убедиться, что все изображения на клоне имеют CORS
          clonedDoc.querySelectorAll('img').forEach(img => {
            if (!img.crossOrigin) img.crossOrigin = 'Anonymous';
          });
        }
      });

      // Создание файла
      if (type === 'jpg') {
        const link = document.createElement('a');
        link.download = 'макет.jpg';
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
      } else if (type === 'pdf') {
        const imgData = canvas.toDataURL('image/jpeg', 0.95);
        const pdf = new window.jsPDF({
          orientation: canvas.width > canvas.height ? 'landscape' : 'portrait',
          unit: 'px',
          format: [canvas.width, canvas.height]
        });
        pdf.addImage(imgData, 'JPEG', 0, 0, canvas.width, canvas.height);
        pdf.save('макет.pdf');
      }
    } catch (error) {
      console.error('Ошибка при создании файла:', error);
      alert('Произошла ошибка при создании файла. Попробуйте ещё раз.');
    } finally {
      downloadModal.style.display = 'none';
      restoreCanvasState(replacedImages);
      if (loader) loader.style.display = 'none';
    }
  };

  // Остальные обработчики событий...
  downloadBtn.addEventListener('click', () => {
    downloadModal.style.display = 'flex';
  });

  closeDownloadBtn.addEventListener('click', () => {
    downloadModal.style.display = 'none';
  });

  downloadModal.addEventListener('click', e => {
    if (e.target === downloadModal) {
      downloadModal.style.display = 'none';
    }
  });

  downloadJPGBtn.addEventListener('click', () => downloadHandler('jpg'));
  downloadPDFBtn.addEventListener('click', () => downloadHandler('pdf'));
}