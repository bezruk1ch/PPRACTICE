<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Визитки',
            'image' => 'business_card_image.png',
        ]);

        Category::create([
            'name' => 'Футболки',
            'image' => 'tshirt_image.png',
        ]);

        Category::create([
            'name' => 'Буклеты',
            'image' => 'brochure_image.png',
        ]);

        // Добавь другие категории по необходимости
    }
}
