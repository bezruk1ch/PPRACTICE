<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use App\Models\Feedback;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->limit(5)->get(); // последние 5 заказов
        $users = User::latest()->limit(5)->get();   // последние 5 пользователей
        $reviews = Review::latest()->limit(5)->get(); // последние 5 отзывов
        $feedbacks = Feedback::latest()->take(5)->get(); // <= вот это добавляем

        return view('admin.dashboard', compact('orders', 'users', 'reviews', 'feedbacks'));
    }
}
