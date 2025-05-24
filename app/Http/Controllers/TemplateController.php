<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Category;

class TemplateController extends Controller
{
    public function getTemplate($type)
    {
        $product = Product::where('type', $type)
            ->with(['options' => function ($query) {
                $query->where('option_type', 'template');
            }])
            ->firstOrFail();

        return response()->json([
            'css_class' => 'tpl-' . Str::slug($type),
            'styles' => [
                'width' => $product->template_width . 'px',
                'height' => $product->template_height . 'px',
                'background' => $product->template_image
                    ? "url('{$product->template_image}') no-repeat center/contain"
                    : ''
            ]
        ]);
    }
}
