<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::create([
            'name' => 'Классическая визитка',
            'preview_image' => 'img/constructor/business_card_template.jpg',
            'description' => 'Простой и строгий стиль',
        ]);
    
        Template::create([
            'name' => 'Современный буклет',
            'preview_image' => 'img/constructorbooklet_template.jpg',
            'description' => 'Яркий и креативный дизайн',
        ]);
    }
}
