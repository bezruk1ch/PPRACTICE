import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



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




document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById('reviewModal');
    const modalAvatar = document.querySelector('.review-modal-avatar');
    const modalName = document.getElementById('reviewModalName');
    const modalDate = document.getElementById('reviewModalDate');
    const modalRating = document.getElementById('reviewModalStars');
    const modalText = document.getElementById('reviewModalText');
    const closeModal = document.getElementById('reviewModalClose');

    document.querySelectorAll('.read-more-btn').forEach(button => {
        button.addEventListener('click', () => {
            const data = JSON.parse(button.dataset.review);

            modalAvatar.src = data.avatar;
            modalName.textContent = `${data.name} ${data.surname}`;
            modalDate.textContent = data.date;
            modalText.textContent = data.text;

            // Звезды
            modalRating.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.className = 'star' + (i <= data.rating ? ' filled' : '');
                star.textContent = '★';
                modalRating.appendChild(star);
            }

            modal.style.display = 'block';
        });
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
