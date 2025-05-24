export function initDeleteHandler() {
    document.addEventListener('keydown', (e) => {
        const selEl = window.selectedElement;
        const isEditing = selEl && selEl.contentEditable === 'true' && document.activeElement === selEl;

        if (!isEditing && e.key === 'Delete' && selEl) {
            e.preventDefault();
            selEl.remove();
            window.selectedElement = null;

            if (typeof window.hideTextEditPanel === 'function') {
                window.hideTextEditPanel();
            }

            // Если есть showEditor — вернёмся к дефолту
            if (typeof window.showEditor === 'function') {
                window.showEditor('default');
            }
        }
    });
}
