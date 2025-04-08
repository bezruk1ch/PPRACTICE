<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание обычного пользователя
        User::create([
            'name' => 'Иван',
            'surname' => 'Иванов',
            'login' => 'ivanivanov',
            'email' => 'ivan.ivanov@mail.ru',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'middle_name' => 'Петрович',
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'phone' => '79001234567',
        ]);

        // Создание администратора
        User::create([
            'name' => 'Admin',
            'surname' => 'User',
            'login' => 'admin', // Логин для администратора
            'email' => 'admin@mail.ru',
            'password' => Hash::make('adminpassword'),
            'role' => 'admin',
            'middle_name' => null,
            'gender' => null,
            'birth_date' => null,
            'phone' => null,
        ]);
    }
}
