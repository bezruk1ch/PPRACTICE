import { initPreviewModal, initDownloadModal } from './modals';
import { initToolbox } from './toolbox.js';

document.addEventListener('DOMContentLoaded', () => {
    // Кнопка "Продолжить", открывающая модальное окно предпросмотра
    const proceedBtn = document.getElementById('proceedBtn');

    // Кнопка "Скачать макет", открывающая модальное окно скачивания
    const downloadBtn = document.querySelector('.download-btn');

    // Кнопки внутри модального окна скачивания
    const closeDownloadBtn = document.getElementById('closeDownloadModal');
    const downloadJPGBtn = document.getElementById('downloadJPG');
    const downloadPDFBtn = document.getElementById('downloadPDF');

    // Инициализация модалки предпросмотра макета
    initPreviewModal(proceedBtn);

    // Инициализация модалки скачивания макета
    initDownloadModal(downloadBtn, closeDownloadBtn, downloadJPGBtn, downloadPDFBtn);

    // Инициализируем панель инструментов
    initToolbox();
});

    //import('./canvas-init');
    //import('./toolbox');
    //import('./background-tools');
    //import('./image-tools');
    //import('./base-templates');
    //import('./zoom-controls');
    //import('./text-elements');
    //import('./image-elements');
    //import('./editor-panel');
    //import('./alignment-tools');
    //import('./delete-copy-lock');
    //import('./drag-resize');
    //import('./utils');
