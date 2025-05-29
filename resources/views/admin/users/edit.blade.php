@extends('layouts.admin')

@section('content')
<h1 class="admin-title">Редактировать пользователя</h1>

<form action="{{ route('admin.users.update',$user) }}" method="POST" style="max-width:500px" class="user-form">
    @csrf @method('PATCH')

    <label>Имя
        <input type="text" name="name" value="{{ old('name',$user->name) }}" required>
    </label>
    @error('name') <div class="text-red-500">{{ $message }}</div>@enderror

    <label>
        <span>Логин</span>
        <input type="text" name="login" value="{{ old('login',$user->login) }}" required>
    </label>
    @error('login') <div class="text-red-500">{{ $message }}</div>@enderror

    <label>Email
        <input type="email" name="email" value="{{ old('email',$user->email) }}" required>
    </label>
    @error('email') <div class="text-red-500">{{ $message }}</div>@enderror

    <label>Роль
        <select name="role">
            <option value="user" @if($user->role==='user') selected @endif>Пользователь</option>
            <option value="admin" @if($user->role==='admin')selected @endif>Администратор</option>
        </select>
    </label>
    @error('role') <div class="text-red-500">{{ $message }}</div>@enderror

    <label>Пароль (оставить пустым для без изменений)
        <input type="password" name="password">
    </label>
    @error('password') <div class="text-red-500">{{ $message }}</div>@enderror

    <label>Подтверждение пароля
        <input type="password" name="password_confirmation">
    </label>

    <button type="submit" class="btn btn-red" style="margin-top:15px">Сохранить</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-gray" style="margin-left:10px">
        Отмена
    </a>
</form>
@endsection