<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Slide;
use App\Models\Portfolio;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем данные пользователя
        $user = Auth::user();

        // Получаем все активные слайды
        $slides = Slide::all();

        $portfolios = Portfolio::all(); // Получаем все работы из базы данных

        $reviews = Review::all(); // Получаем все работы из базы данных

        // Передаем данные в представление
        return view('home', [
            'user' => $user,
            'slides' => $slides,
            'portfolios' => $portfolios,
            'reviews' => $reviews,
        ]);

    }
}
