<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Portfolio;


class PortfolioController extends Controller
{
    public function index()
    {
        // Получаем данные пользователя
        $user = Auth::user();

        $portfolios = Portfolio::all(); // Получаем все работы из базы данных

        // Передаем данные в представление
        return view('layouts.pages.portfolio-page', [
            'user' => $user,
            'portfolios' => $portfolios,
        ]);
    }
}
