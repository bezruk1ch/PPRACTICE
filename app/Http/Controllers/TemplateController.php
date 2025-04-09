<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Category;

class TemplateController extends Controller
{
    // Метод для отображения шаблонов по категориям
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id');
        $templates = Template::when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->get();

        $categories = Category::all(); // Получаем все категории

        return view('templates.index', compact('templates', 'categories'));
    }
}
