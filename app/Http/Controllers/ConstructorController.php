<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ConstructorController extends Controller
{
    public function index()
    {
        // Получаем данные пользователя
        $user = Auth::user();

        // Передаем данные в представление
        return view('layouts.pages.constructor', [
            'user' => $user,
        ]);
    }
}
