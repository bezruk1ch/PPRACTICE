<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $orders = Order::with('items')->where('user_id', $user->id)->get();

        $currentOrders = $orders->whereIn('status', ['new', 'in_progress', 'pending']);
        $pastOrders = $orders->where('status', 'completed');

        return view('layouts.pages.profile', compact('user', 'currentOrders', 'pastOrders'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'login' => 'nullable|string|max:255|unique:users,login,' . $user->id,
            'password' => 'nullable|string|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обработка изображения профиля
        if ($request->hasFile('profile_picture')) {
            // Получаем файл изображения
            $image = $request->file('profile_picture');
            // Генерируем уникальное имя для изображения
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Перемещаем изображение в папку img/users
            $image->move(public_path('img/users'), $imageName);
            // Добавляем путь к изображению в массив данных для обновления
            $validatedData['profile_picture'] = 'img/users/' . $imageName;
        } else {
            // Если изображение не изменялось, оставляем старое
            $validatedData['profile_picture'] = $user->profile_picture;
        }

        // Обновляем только если пароль введён
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // иначе не затирай текущий пароль пустым
        }

        $user->update($validatedData);

        return redirect()->route('profile')->with('success', 'Профиль обновлён');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Получаем текущего пользователя
        $user = Auth::user();

        // Сохраняем отзыв в базу данных, добавляем user_name, user_surname и user_avatar
        Review::create([
            'user_id' => $user->id, // Используем текущего авторизованного пользователя
            'user_name' => $user->name,  // Имя пользователя
            'user_surname' => $user->surname, // Фамилия пользователя
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_avatar' => $user->profile_picture, // Если у пользователя есть аватар
        ]);

        return redirect()->route('profile')->with('success', 'Ваш отзыв успешно оставлен!');
    }
}
