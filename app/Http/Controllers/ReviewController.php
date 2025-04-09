<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Получаем все отзывы, исключая отзывы компаний
        $reviews = Review::where('is_company', false)->get();

        // Получаем данные пользователя
        $user = Auth::user();

        // Отправляем данные в представление
        return view('layouts.pages.reviews', [
            'user' => $user,
            'reviews' => $reviews,
        ]);
    }
}
