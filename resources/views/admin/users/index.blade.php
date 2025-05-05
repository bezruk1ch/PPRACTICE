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
    @vite(['resources/css/admin.css'])
    
    <title>Админка</title>
</head>

<h2>Пользователи</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Отчество</th>
        <th>Логин</th>
        <th>Пол</th>
        <th>Дата рождения</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Фото</th>
        <th>Роль</th>
        <th>Действия</th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->surname }}</td>
            <td>{{ $user->middle_name ?? '-' }}</td>
            <td>{{ $user->login }}</td>
            <td>
                @if ($user->gender === 'male') Мужской
                @elseif ($user->gender === 'female') Женский
                @elseif ($user->gender === 'other') Другое
                @else - @endif
            </td>
            <td>{{ $user->birth_date ?? '-' }}</td>
            <td>{{ $user->phone ?? '-' }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->profile_picture)
                    <img src="{{ asset($user->profile_picture) }}" alt="Аватар" width="40" height="40" style="object-fit: cover; border-radius: 50%;">
                @else
                    -
                @endif
            </td>
            <td>{{ $user->is_admin ? 'Админ' : 'Пользователь' }}</td>
            <td><a href="{{ route('admin.users.edit', $user) }}">Редактировать</a></td>
        </tr>
    @endforeach
</table>

</html>