<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\ProductOption;


class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Стандартная визитка',
                'type' => 'Визитка',
                'base_price' => 100,
                'template_width' => 600,
                'template_height' => 300,
                'template_image' => null,
                'options' => [
                    ['paper_quality', 'Стандартная', 0],
                    ['paper_quality', 'Премиум', 50],
                    ['lamination', 'Без ламинации', 0],
                    ['lamination', 'Глянцевая', 30],
                    ['lamination', 'Матовая', 25]
                ]
            ],
            [
                'name' => 'Хлопковая футболка',
                'type' => 'Футболка',
                'base_price' => 500,
                'template_width' => 800,
                'template_height' => 850,
                'template_image' => '/img/constructor/tshirt.png',
                'options' => [
                    ['size', 'S', 0],
                    ['size', 'M', 0],
                    ['size', 'L', 0],
                    ['color', 'Белый', 0],
                    ['color', 'Черный', 50],
                    ['print_type', 'Стандартный', 0],
                    ['print_type', 'Премиум', 150]
                ]
            ],
            [
                'name' => 'Плакат А3',
                'type' => 'Постер',
                'base_price' => 300,
                'template_width' => 1000,
                'template_height' => 1400,
                'template_image' => null,
                'options' => [
                    ['material', 'Бумага', 0],
                    ['material', 'Холст', 200],
                    ['lamination', 'Без ламинации', 0],
                    ['lamination', 'Глянцевая', 80],
                    ['lamination', 'Матовая', 70]
                ]
            ],
            [
                'name' => 'Стандартный буклет',
                'type' => 'Буклет',
                'base_price' => 200,
                'template_width' => 400,
                'template_height' => 200,
                'template_image' => null,
                'options' => [
                    ['pages', '4 страницы', 0],
                    ['pages', '8 страниц', 100],
                    ['binding', 'Скоба', 0],
                    ['binding', 'Клей', 50],
                    ['paper_quality', 'Мелованная', 30]
                ]
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'type' => $productData['type'],
                'base_price' => $productData['base_price'],
                'template_width' => $productData['template_width'],
                'template_height' => $productData['template_height'],
                'template_image' => $productData['template_image']
            ]);

            foreach ($productData['options'] as $option) {
                $product->options()->create([
                    'option_type' => $option[0],
                    'option_name' => $option[1],
                    'price_modifier' => $option[2]
                ]);
            }
        }
    }
}
