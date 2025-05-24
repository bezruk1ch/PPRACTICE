export function initZoomControls() {
    const canvasArea = document.querySelector('.canvas-area');
    let zoomLevel = 1;

    const zoomValue = document.getElementById('zoomValue');
    const zoomInBtn = document.getElementById('zoomInBtn');
    const zoomOutBtn = document.getElementById('zoomOutBtn');

    zoomInBtn.addEventListener('click', () => {
        zoomLevel = Math.min(2, zoomLevel + 0.1);
        canvasArea.style.transform = `scale(${zoomLevel})`;
        zoomValue.textContent = `${Math.round(zoomLevel * 100)}%`;
    });

    zoomOutBtn.addEventListener('click', () => {
        zoomLevel = Math.max(0.5, zoomLevel - 0.1);
        canvasArea.style.transform = `scale(${zoomLevel})`;
        zoomValue.textContent = `${Math.round(zoomLevel * 100)}%`;
    });

    // По желанию: сделать текущий уровень зума доступным глобально
    window.getZoomLevel = () => zoomLevel;
}
