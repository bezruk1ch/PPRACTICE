<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Portfolio;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portfolio::create([
            'image' => 'img/portfolio/1.png',
            'title' => "Визитки для кафе\n'Кофейный уголок'",
            'description' => 'Визитки были разработаны для кафе "Кофейный уголок", чтобы помочь заведению выделиться среди конкурентов и создать запоминающийся образ для клиентов. Основная задача проекта — передать уютную и теплую атмосферу кафе, а также предоставить гостям удобный доступ к контактной информации и меню.',
            'tags' => '#Визитки #Брендинг #Кафе #Минимализм #Пастельныетона #QR-код #Полиграфия #Фирменныйстиль',
            'category' => 'Визитки', // Основная категория
        ]);

        Portfolio::create([
            'image' => 'img/portfolio/2.png',
            'title' => "Буклет для фестиваля\n'Осенний джаз'",
            'description' => '(Описание)',
            'tags' => '(Тэги)',
            'category' => 'Буклеты', // Основная категория
        ]);

        Portfolio::create([
            'image' => 'img/portfolio/3.png',
            'title' => "Вывеска для магазина\n'Стиль и мода'",
            'description' => '(Описание)',
            'tags' => '(Тэги)',
            'category' => 'Вывески', // Основная категория
        ]);

        Portfolio::create([
            'image' => 'img/portfolio/4.png',
            'title' => "Футболки с логотипо\nдля фитнес-клуба",
            'description' => '(Описание)',
            'tags' => '(Тэги)',
            'category' => 'Одежда', // Основная категория
        ]);

        Portfolio::create([
            'image' => 'img/portfolio/5.png',
            'title' => "Лендинг для\nстудии йоги",
            'description' => '(Описание)',
            'tags' => '(Тэги)',
            'category' => 'Сайты', // Основная категория
        ]);

        Portfolio::create([
            'image' => 'img/portfolio/6.png',
            'title' => "Листовка для акции\n'Скидка 20% на всё!'",
            'description' => '(Описание)',
            'tags' => '(Тэги)',
            'category' => 'Листовки', // Основная категория
        ]);
    }
}
