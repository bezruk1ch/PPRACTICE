<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class aboutcontroller extends Controller
{
    public function index()
    {
        // Получаем данные пользователя
        $user = Auth::user();

        // Передаем данные в представление
        return view('layouts.pages.about-us-page', [
            'user' => $user,
        ]);
    }
}
