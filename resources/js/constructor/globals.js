export function initGlobals() {
    window.canvas = document.getElementById('canvas');
    window.draggedElement = null;
    window.offsetX = 0;
    window.offsetY = 0;
    window.selectedElement = null;
    window.resizing = false;
    window.resizingElement = null;
    window.resizingHandle = null;
    window.startX = 0;
    window.startWidth = 0;
    window.startLeft = 0;
    window.currentZIndex = 1;
}
