<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Сидовые отзывы (без user_id)
        Review::create([
            'user_name' => 'Игорь',
            'user_surname' => 'Безруков',
            'user_avatar' => 'img/reviews/igor.png', // Путь к фото в `public`
            'rating' => 5,
            'comment' => 'Заказывал визитки для своей компании. Качество печати на высшем уровне, сроки соблюдены. Единственное, хотелось бы больше вариантов дизайна. В целом, рекомендую! 

Что особенно понравилось, так это внимательное отношение к деталям. Менеджер подробно объяснил все этапы работы, помог выбрать подходящий тип бумаги и ответил на все мои вопросы. Также хочу отметить оперативность: визитки были готовы даже немного раньше обещанного срока, что стало приятным сюрпризом.

В общем, если вы ищете надежную типографию, где можно заказать качественную полиграфию без лишних хлопот, то "А ПЛЮС" — отличный выбор. Обязательно вернусь сюда с новыми заказами!',
            'created_at' => now()->setDate(2025, 3, 6)
        ]);

        Review::create([
            'user_name' => 'Мария',
            'user_surname' => 'Петрова',
            'user_avatar' => 'img/reviews/maria.png',
            'rating' => 5,
            'comment' => 'Очень довольна сотрудничеством! Заказала буклеты для мероприятия, все сделали быстро и качественно. Дизайн просто шикарный. Обязательно обращусь еще раз!',
            'created_at' => now()->setDate(2024, 10, 10)
        ]);

        Review::create([
            'user_name' => 'Елена',
            'user_surname' => 'Кузнецова',
            'user_avatar' => 'img/reviews/elena.png',
            'rating' => 5,
            'comment' => 'Огромное спасибо за оперативность и качество! Заказала сувенирные кружки с логотипом компании, все сделали идеально. Теперь все клиенты в восторге от подарков!',
            'created_at' => now()->setDate(2025, 12, 10)
        ]);

        Review::create([
            'user_name' => 'Типография',
            'user_surname' => '«А плюс»',
            'user_avatar' => 'img/reviews/logo.png',
            'rating' => 5,
            'comment' => 'Мы будем благодарны, если вы оставите отзыв о нашей продукции и сервисе. Ваше мнение помогает нам становиться лучше!',
            'created_at' => now(),
            'is_company' => true,
        ]);
    }
}
