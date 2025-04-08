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

        $currentOrders = [];
        $pastOrders = [];

        // Получаем все отзывы пользователя
        $reviews = Review::where('user_id', $user->id)->get();

        return view('layouts.pages.profile', compact('user', 'currentOrders', 'pastOrders'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'password' => 'nullable|string|confirmed|min:6',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Удалить старую, если есть
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('profile_picture')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->fill($validated);

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлён.');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Сохраняем отзыв в базу данных
        Review::create([
            'user_id' => Auth::id(), // Используем текущего авторизованного пользователя
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('profile')->with('success', 'Ваш отзыв успешно оставлен!');
    }
}
