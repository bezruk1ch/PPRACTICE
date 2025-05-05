import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', function () {
    // Открытие модального окна
    document.querySelectorAll('.read-more-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const reviewData = JSON.parse(this.dataset.review);

            // Заполняем модальное окно
            document.getElementById('modalAvatar').src = reviewData.avatar;
            document.getElementById('modalFirstName').textContent = reviewData.name;
            document.getElementById('modalLastName').textContent = reviewData.surname;
            document.getElementById('modalReviewText').textContent = reviewData.text;
            document.getElementById('modalDate').textContent = reviewData.date;

            // Генерируем звёзды рейтинга
            const ratingContainer = document.getElementById('modalRating');
            ratingContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.className = `star ${i <= reviewData.rating ? 'filled' : ''}`;
                star.textContent = '★';
                ratingContainer.appendChild(star);
            }

            // Показываем модалку
            document.getElementById('reviewModal').style.display = 'flex';
        });
    });

    // Закрытие модалки
    document.querySelector('.close-modal').addEventListener('click', function () {
        document.getElementById('reviewModal').style.display = 'none';
    });

    // Закрытие при клике вне окна
    window.addEventListener('click', function (e) {
        if (e.target === document.getElementById('reviewModal')) {
            document.getElementById('reviewModal').style.display = 'none';
        }
    });
});



document.addEventListener('DOMContentLoaded', function () {
    ymaps.ready(init);

    function init() {
        // Координаты офиса (г. Челябинск, ул. Братьев Кашириных, 73)
        var officeCoordinates = [55.145576, 61.402335]; // Замените на реальные координаты

        var map = new ymaps.Map('map', {
            center: officeCoordinates,
            zoom: 16
        });

        // Добавляем метку
        var officePlacemark = new ymaps.Placemark(officeCoordinates, {
            hintContent: 'ООО "А плюс"',
            balloonContent: 'Офис компании А плюс<br>ул. Братьев Кашириных, 73'
        });

        map.geoObjects.add(officePlacemark);
    }
});




document.addEventListener('DOMContentLoaded', function () {
    // Инициализация canvas
    const template = JSON.parse(document.getElementById('design-editor').dataset.template);
    const canvas = new fabric.Canvas('design-editor', {
        width: 800,
        height: 600,
        backgroundColor: '#ffffff'
    });

    // Загрузка фона шаблона
    if (template.background) {
        fabric.Image.fromURL('/storage/' + template.background, function (img) {
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height
            });
        });
    }

    // Добавление текста
    document.getElementById('add-text').addEventListener('click', function () {
        const textValue = document.getElementById('text-input').value.trim();
        if (textValue) {
            const text = new fabric.Text(textValue, {
                left: 100,
                top: 100,
                fontFamily: 'Arial',
                fill: '#000000',
                fontSize: 20
            });
            canvas.add(text);
            document.getElementById('text-input').value = '';
        }
    });

    // Добавление изображения
    document.getElementById('add-image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (f) {
            fabric.Image.fromURL(f.target.result, function (img) {
                img.scaleToWidth(200);
                canvas.add(img);
            });
        };
        reader.readAsDataURL(file);
        e.target.value = '';
    });

    // Сохранение дизайна
    document.getElementById('save-design').addEventListener('click', function () {
        if (canvas.getObjects().length === 0) {
            alert('Пожалуйста, добавьте элементы в дизайн перед сохранением');
            return;
        }

        const preview = canvas.toDataURL('png');
        const content = JSON.stringify(canvas.toJSON());

        fetch(route('constructor.store'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                template_id: template.id,
                content: content,
                preview: preview
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Ошибка сохранения: ' + (data.message || 'Неизвестная ошибка'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при сохранении');
            });
    });
});







document.addEventListener('DOMContentLoaded', function () {
    const feedbackButton = document.getElementById('feedbackButton');
    const feedbackModal = document.getElementById('feedbackModal');
    const closeModal = document.getElementById('closeModal');
    const feedbackForm = document.getElementById('feedbackForm');

    // Открытие модального окна
    feedbackButton.addEventListener('click', function () {
        feedbackModal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Блокируем прокрутку страницы
    });

    // Закрытие модального окна
    closeModal.addEventListener('click', function () {
        feedbackModal.classList.remove('active');
        document.body.style.overflow = ''; // Восстанавливаем прокрутку
    });

    // Закрытие при клике вне формы
    feedbackModal.addEventListener('click', function (e) {
        if (e.target === feedbackModal) {
            feedbackModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Обработка отправки формы
    feedbackForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Здесь можно добавить AJAX-запрос для отправки данных
        const formData = new FormData(feedbackForm);

        // Пример вывода данных в консоль (замените на реальную отправку)
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Показываем сообщение об успешной отправке
        alert('Спасибо! Ваше сообщение отправлено.');

        // Закрываем модальное окно и сбрасываем форму
        feedbackModal.classList.remove('active');
        feedbackForm.reset();
        document.body.style.overflow = '';
    });
});





// Подвал

// Получаем элементы
const subscribeButton = document.getElementById('subscribe-button');
const modal = document.getElementById('subscribe-modal');
const closeButton = document.getElementById('close-button');
const subscribeForm = document.getElementById('subscribe-form');

// Открытие модального окна при нажатии на кнопку
subscribeButton.addEventListener('click', () => {
    modal.classList.add('active');
});

// Закрытие модального окна
closeButton.addEventListener('click', () => {
    modal.classList.remove('active');
});

// Закрытие модального окна при клике вне его
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.classList.remove('active');
    }
});

// Обработка отправки формы (например, просто выводим email в консоль)
subscribeForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const email = document.getElementById('email').value;
    alert(`Вы подписались на новости с email: ${email}`);
    modal.classList.remove('active'); // Закрыть окно после отправки
});


// Шапка 

document.getElementById('call-button').addEventListener('click', function () {
    const phoneNumber = document.querySelector('.call-text').innerText;

    // Создаем временный элемент для копирования
    const textarea = document.createElement('textarea');
    textarea.value = phoneNumber;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    // Уведомление о том, что номер скопирован
    alert('Номер телефона скопирован в буфер обмена!');
});



document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('profile_picture');
    const preview = document.getElementById('avatarPreview');

    input.addEventListener('change', function () {
        const file = this.files[0];

        // Проверка на тип файла
        if (file && !file.type.startsWith('image/')) {
            alert('Можно загружать только изображения (JPG, PNG, GIF и т.д.)');
            input.value = ''; // очищаем input
            return;
        }

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});





// ОТЗЫВЫ

document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 0;
    const reviewsGrid = document.querySelector('.reviews-grid');
    const reviewsPerPage = 4;
    const totalReviews = document.getElementById('totalReviews').value;  // Берем из скрытого поля

    function scrollReviews(direction) {
        currentPage += direction;

        // Рассчитываем новое смещение
        const cardWidth = reviewsGrid.querySelector('.review-card').offsetWidth; // Получаем ширину карточки
        const offset = currentPage * (reviewsPerPage * cardWidth); // Используем динамическую ширину

        // Прокручиваем контейнер
        reviewsGrid.style.transform = `translateX(-${offset}px)`;

        // Деактивируем кнопки, если достигнуты пределы
        if (currentPage <= 0) {
            document.querySelector('.prev-btn').disabled = true;
        } else {
            document.querySelector('.prev-btn').disabled = false;
        }

        if (currentPage >= Math.ceil(totalReviews / reviewsPerPage) - 1) {
            document.querySelector('.next-btn').disabled = true;
        } else {
            document.querySelector('.next-btn').disabled = false;
        }
    }

    // Инициализация кнопок
    document.querySelector('.prev-btn').addEventListener('click', function () {
        scrollReviews(-1);
    });
    document.querySelector('.next-btn').addEventListener('click', function () {
        scrollReviews(1);
    });
});