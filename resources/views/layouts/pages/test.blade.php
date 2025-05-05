<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест выравнивания</title>
    <style>
        body {
            font-family: sans-serif;
        }

        #canvas {
            position: relative;
            width: 600px;
            height: 400px;
            border: 2px solid #333;
            margin: 20px auto;
            background-color: #f8f8f8;
            overflow: hidden;
        }

        .draggable {
            position: absolute;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            user-select: none;
        }

        .controls {
            text-align: center;
            margin-top: 10px;
        }

        .controls button {
            margin: 5px;
        }
    </style>
</head>
<body>

<div id="canvas">
    <div id="element" class="draggable">Текст</div>
</div>

<div class="controls">
    <span>Выравнивание по холсту:</span><br>
    <button onclick="align('left')">⯇ Лево</button>
    <button onclick="align('center')">☰ Центр</button>
    <button onclick="align('right')">⯈ Право</button><br>
    <button onclick="align('top')">↑ Верх</button>
    <button onclick="align('middle')">↕ Середина</button>
    <button onclick="align('bottom')">↓ Низ</button>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const element = document.getElementById('element');

    function align(direction) {
        const cW = canvas.offsetWidth;
        const cH = canvas.offsetHeight;
        const eW = element.offsetWidth;
        const eH = element.offsetHeight;

        let left = parseFloat(element.style.left) || element.offsetLeft;
        let top = parseFloat(element.style.top) || element.offsetTop;

        switch (direction) {
            case 'left':
                left = 0;
                break;
            case 'center':
                left = (cW - eW) / 2;
                break;
            case 'right':
                left = cW - eW;
                break;
            case 'top':
                top = 0;
                break;
            case 'middle':
                top = (cH - eH) / 2;
                break;
            case 'bottom':
                top = cH - eH;
                break;
        }

        element.style.left = `${left}px`;
        element.style.top = `${top}px`;
    }

    // Центрируем изначально
    window.onload = () => {
        align('center');
        align('middle');
    };
</script>

</body>
</html>
