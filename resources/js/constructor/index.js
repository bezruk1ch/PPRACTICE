import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

import { initPreviewModal, initDownloadModal } from './modals';
import { initToolbox } from './toolbox.js';
import { initTextEditorPanel } from './text-editor-panel.js';
import { showEditor, initEditorPanel } from './editor-panel.js';
window.showEditor = showEditor;
import { initGlobals } from './globals.js';
import { initZoomControls } from './zoom-controls.js';
import { initDeleteHandler } from './delete-handler.js';
import { initImageEditorPanel } from './image-editor-panel.js';




// Подключаем html2canvas и jsPDF глобально
window.html2canvas = html2canvas;
window.jsPDF = jsPDF;

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

    // Инициализируем панель редактирования текста
    initTextEditorPanel();

    initEditorPanel();

    initGlobals();

    initZoomControls();

    initDeleteHandler();

    initImageEditorPanel();
});