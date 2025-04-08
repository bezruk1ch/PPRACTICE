<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slide;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slide::create([
            'image' => 'img/slides/slide-1.png',
            'title' => "Качественная\nполиграфия и реклама", // Используем \n
            'description' => "Изготовление визиток, баннеров,\nсувениров и многое другое", // Используем \n
            'button_text' => 'Заказать сейчас',
        ]);
        
        Slide::create([
            'image' => 'img/slides/slide-2.png',
            'title' => "Создаем стиль\nвашего бренда", // Используем \n
            'description' => "Индивидуальный дизайн\nи оперативное выполнение заказов", // Используем \n
            'button_text' => 'Узнать больше',
        ]);
        
        Slide::create([
            'image' => 'img/slides/slide-3.png',
            'title' => "Скидка 10% на\nпервый заказ!", // Используем \n
            'description' => "Успейте заказать до конца месяца", // Используем \n
            'button_text' => 'Получить скидку',
        ]);
        
        Slide::create([
            'image' => 'img/slides/slide-4.png',
            'title' => "Верстка сайтов\nпод ключ", // Используем \n
            'description' => "Создаем адаптивные и\nсовременные веб-страницы", // Используем \n
            'button_text' => 'Заказать сайт',
        ]);
    }
}
