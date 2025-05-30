import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

import { initPreviewModal, initDownloadModal } from './modals';
import { initToolbox } from './toolbox.js';
import { initTextEditorPanel } from './text-editor-panel.js';
import { showEditor, initEditorPanel } from './editor-panel.js';
import { initGlobals } from './globals.js';
import { initZoomControls } from './zoom-controls.js';
import { initDeleteHandler } from './delete-handler.js';
import { initImageEditorPanel } from './image-editor-panel.js';



window.html2canvas = html2canvas;
window.jsPDF = jsPDF;
window.showEditor = showEditor;

document.addEventListener('DOMContentLoaded', () => {
    // Показать модальное окно выбора основы
    const modal = document.getElementById('templateModal');
    if (modal) {
        modal.style.display = 'flex';

        // Закрыть модалку и применить шаблон при выборе кнопки основы
        modal.querySelectorAll('.select-template-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // здесь у вас уже есть логика applyCanvasTemplate и sessionStorage
                // просто не забудьте после неё:
                modal.style.display = 'none';
            });
        });
    }

    initPreviewModal(
        document.getElementById('proceedBtn'),
        document.querySelector('.download-btn'),
        document.getElementById('closeDownloadModal'),
        document.getElementById('downloadJPG'),
        document.getElementById('downloadPDF')
    );
    initDownloadModal(
        document.querySelector('.download-btn'),
        document.getElementById('closeDownloadModal'),
        document.getElementById('downloadJPG'),
        document.getElementById('downloadPDF')
    );
    initToolbox();
    initTextEditorPanel();
    initEditorPanel();
    initGlobals();

    initZoomControls();
    initDeleteHandler();
    initImageEditorPanel();

    
});
