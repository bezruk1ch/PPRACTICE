<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        DB::table('templates')->insert([
            [
                'category_id' => 1, // Визитки
                'name' => 'Шаблон 1',
                'image' => 'business_card_image.png',
                'font' => 'Arial',
                'background_color' => '#FFFFFF',
            ],
            [
                'category_id' => 1, // Визитки
                'name' => 'Шаблон 2',
                'image' => 'business_card_image.png',
                'font' => 'Verdana',
                'background_color' => '#F1F1F1',
            ],
            // Добавь другие шаблоны по необходимости
        ]);
    }
}
