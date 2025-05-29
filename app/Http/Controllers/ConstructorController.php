<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Template;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ConstructorController extends Controller
{
    public function index()
    {
        // Получаем данные пользователя
        $user = Auth::user();

        // Получаем все продукты из базы данных
        $products = Product::all();

        // Находим продукт "Стандартная визитка"
        $defaultProduct = Product::where('name', 'Стандартная визитка')->first();

        // Передаем данные в представление
        return view('layouts.pages.constructor', [
            'user' => $user,
            'products' => $products,
            'defaultProduct' => $defaultProduct, // добавили
        ]);
    }
}
