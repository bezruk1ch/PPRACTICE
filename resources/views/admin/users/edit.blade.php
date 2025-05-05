<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
    @vite(['resources/css/admin-admin.css'])

    <title>Админка</title>
</head>

<h2>Редактирование пользователя</h2>

<form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Эта директива указывает, что запрос будет PUT -->
    <label>Имя:</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}"><br>

    <label>Фамилия:</label>
    <input type="text" name="surname" value="{{ old('surname', $user->surname) }}"><br>

    <label>Отчество:</label>
    <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}"><br>

    <label>Логин:</label>
    <input type="text" name="login" value="{{ old('login', $user->login) }}"><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}"><br>

    <label>Телефон:</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"><br>

    <label>Дата рождения:</label>
    <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}"><br>

    <label>Пол:</label>
    <select name="gender">
        <option value="">Не выбрано</option>
        <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Мужской</option>
        <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Женский</option>
        <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Другое</option>
    </select><br>

    <label>Пароль (оставьте пустым, если не меняется):</label>
    <input type="password" name="password"><br>

    <label>Роль:</label>
    <select name="role">
        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Пользователь</option>
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Администратор</option>
    </select><br>

    <label>Фото профиля:</label>
    <input type="file" name="profile_picture"><br>
    @if ($user->profile_picture)
    <img src="{{ asset($user->profile_picture) }}" alt="Фото" width="60" height="60" style="object-fit: cover; border-radius: 50%;">
    @endif
    <br>

    <label>Администратор:</label>
    <input type="checkbox" name="is_admin" {{ $user->is_admin ? 'checked' : '' }}><br><br>

    <button type="submit">Сохранить</button>
</form>



</html>