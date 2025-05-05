<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Валидируем входящие данные
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_admin' => 'nullable|boolean',
        ]);

        // Обновляем данные пользователя
        $user->name = $validated['name'];
        $user->surname = $validated['surname'];
        $user->middle_name = $validated['middle_name'];
        $user->login = $validated['login'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->birth_date = $validated['birth_date'];
        $user->gender = $validated['gender'];
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }
        $user->role = $validated['role'];
        $user->is_admin = $validated['is_admin'] ?? false;

        // Обработка загрузки фото профиля
        if ($request->hasFile('profile_picture')) {
            // Удаляем старое изображение, если оно существует
            if ($user->profile_picture) {
                unlink(storage_path('app/public/' . $user->profile_picture));
            }

            // Сохраняем новое фото
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save(); // Сохраняем изменения

        return redirect()->route('admin.users.index')->with('success', 'Данные пользователя обновлены.');
    }
}
