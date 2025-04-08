<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'middle_name' => ['nullable', 'string', 'max:255'], // Отчество
            'gender' => ['nullable', 'in:male,female,other'], // Пол
            'birth_date' => ['nullable', 'date'], // Дата рождения
            'phone' => ['nullable', 'string', 'max:15', 'unique:' . User::class], // Телефон
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'login' => $request->login,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'middle_name' => $request->middle_name, // Отчество
            'gender' => $request->gender, // Пол
            'birth_date' => $request->birth_date, // Дата рождения
            'phone' => $request->phone, // Телефон
            'role' => 'user', // Устанавливаем роль по умолчанию
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
