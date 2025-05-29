<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1) Список всех пользователей
    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // 2) Форма редактирования
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 3) Обновление данных
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'login'    => 'required|string|max:50|unique:users,login,'.$user->id,
            'role'     => 'required|in:user,admin',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->login = $data['login'];
        $user->role  = $data['role'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success','Пользователь обновлён.');
    }

    // 4) Удаление
    public function destroy(User $user)
    {
        // нельзя удалять самого себя
        if (auth()->id() === $user->id) {
            return back()->with('error','Нельзя удалить свой аккаунт.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success','Пользователь удалён.');
    }
}
