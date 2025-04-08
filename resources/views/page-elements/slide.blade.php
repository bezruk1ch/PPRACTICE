 <!-- Контейнер для слайдера и кнопок -->
 <div class="slider-container">
     <!-- Кнопка "Назад" -->
     <button class="slider-button prev" onclick="prevSlide()">&#10094;</button>

     <!-- Слайдер -->
     <div class="slider">
         @foreach ($slides as $index => $slide)
         <div class="slide {{ $index === 0 ? 'active' : '' }}">
             <!-- Левая часть слайда (текст и кнопка) -->
             <div class="slide-content">
                 <!-- Контейнер для заголовка и описания -->
                 <div class="slide-text">
                     <h2 class="slide-title">{!! nl2br(e($slide->title)) !!}</h2>
                     <p class="slide-description">{!! nl2br(e($slide->description)) !!}</p>
                 </div>

                 <!-- Кнопка -->
                 <button class="slide-button">
                     {{ $slide->button_text }}
                 </button>
             </div>

             <!-- Правая часть слайда (изображение) -->
             <div class="slide-image">
                 <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}">
             </div>
         </div>
         @endforeach
     </div>

     <!-- Кнопка "Вперед" -->
     <button class="slider-button next" onclick="nextSlide()">&#10095;</button>
 </div>

 <!-- Остальной контент страницы -->

 <!-- Скрипт для слайдера -->
 <script>
     let currentSlide = 0;
     const slides = document.querySelectorAll('.slide');

     // Функция для показа текущего слайда
     function showSlide(index) {
         slides.forEach((slide, i) => {
             slide.classList.toggle('active', i === index);
         });
     }

     // Функция для переключения на следующий слайд
     function nextSlide() {
         currentSlide = (currentSlide + 1) % slides.length;
         showSlide(currentSlide);
     }

     // Функция для переключения на предыдущий слайд
     function prevSlide() {
         currentSlide = (currentSlide - 1 + slides.length) % slides.length;
         showSlide(currentSlide);
     }

     // Автоматическое переключение слайдов каждые 5 секунд
     setInterval(nextSlide, 5000);
 </script>
 </body>

 </html>