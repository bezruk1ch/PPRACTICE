// modals.js
// ====== МОДАЛЬНЫЕ ОКНА ======

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

  // Обработка подтверждения названия проекта
  confirmProjectNameBtn.addEventListener('click', () => {
    const projectName = projectNameInput.value.trim() || 'Без названия';
    
    // Сохраняем название в sessionStorage
    sessionStorage.setItem('currentProjectName', projectName);
    
    // Перенаправляем в корзину
    window.location.href = '/cart';
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

  if (!downloadModal || !downloadBtn || !closeDownloadBtn || !downloadJPGBtn || !downloadPDFBtn || !canvasElement) return;

  // Открытие модального окна
  downloadBtn.addEventListener('click', () => {
    downloadModal.style.display = 'flex';
  });

  // Закрытие по кнопке "×"
  closeDownloadBtn.addEventListener('click', () => {
    downloadModal.style.display = 'none';
  });

  // Закрытие по клику вне содержимого
  downloadModal.addEventListener('click', e => {
    if (e.target === downloadModal) {
      downloadModal.style.display = 'none';
    }
  });

  // Скачивание JPG
  downloadJPGBtn.addEventListener('click', () => {
    window.html2canvas(canvasElement).then(canvas => {
      const link = document.createElement('a');
      link.download = 'макет.jpg';
      link.href = canvas.toDataURL('image/jpeg');
      link.click();
      downloadModal.style.display = 'none';
    });
  });

  // Скачивание PDF
  downloadPDFBtn.addEventListener('click', () => {
    window.html2canvas(canvasElement).then(canvas => {
      const imgData = canvas.toDataURL('image/jpeg');
      const pdf = new window.jsPDF({
        orientation: 'landscape',
        unit: 'px',
        format: [canvas.width, canvas.height]
      });
      pdf.addImage(imgData, 'JPEG', 0, 0, canvas.width, canvas.height);
      pdf.save('макет.pdf');
      downloadModal.style.display = 'none';
    });
  });
}