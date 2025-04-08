<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('design_templates')->insert([
            [
                'name' => 'Классическая визитка',
                'type' => 'business_card',
                'thumbnail' => 'templates/business_card_1.jpg',
                'structure' => json_encode([
                    'width' => 90,
                    'height' => 50,
                    'fields' => [
                        ['name' => 'name', 'type' => 'text', 'default' => 'Ваше имя'],
                        ['name' => 'position', 'type' => 'text', 'default' => 'Должность']
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Современный буклет',
                'type' => 'booklet',
                'thumbnail' => 'templates/booklet_1.jpg',
                'structure' => json_encode([
                    'width' => 210,
                    'height' => 100,
                    'fields' => [
                        ['name' => 'title', 'type' => 'text', 'default' => 'Заголовок'],
                        ['name' => 'main_image', 'type' => 'image']
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
