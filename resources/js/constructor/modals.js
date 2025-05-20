// modals.js


// ====== МОДАЛЬНОЕ ОКНО "ПРОВЕРЬТЕ МАКЕТ" ======

/**
 * Инициализирует модальное окно проверки макета
 * @param {HTMLElement} proceedBtn - Кнопка "Продолжить", открывающая модалку
 */
export function initPreviewModal(proceedBtn) {
  const previewModal = document.getElementById('preview-modal');
  if (!previewModal || !proceedBtn) return;

  // Кнопки внутри модального окна
  const previewBtns = previewModal.querySelectorAll('.preview-buttons .btn');

  // Кнопка закрытия модального окна
  const closeBtn = document.getElementById('closePreviewModal');
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      previewModal.style.display = 'none';
    });
  }

  // Открытие модального окна по кнопке "Продолжить"
  proceedBtn.addEventListener('click', () => {
    previewModal.style.display = 'flex';
  });

  // Обработчики на кнопки действий внутри окна
  previewBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const action = btn.textContent.trim();

      switch (action) {
        case 'Лицевая сторона':
          document.getElementById('frontSideBtn')?.click();
          break;
        case 'Оборотная сторона':
          document.getElementById('backSideBtn')?.click();
          break;
        case 'Сделать заказ':
          window.location.href = '/cart';
          break;
        case 'Скачать макет':
          document.querySelector('.download-btn')?.click();
          break;
        case 'Вернуться к редактированию':
          previewModal.style.display = 'none';
          break;
      }
    });
  });

  // Закрытие модалки по клику вне содержимого
  previewModal.addEventListener('click', e => {
    if (e.target === previewModal) {
      previewModal.style.display = 'none';
    }
  });
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