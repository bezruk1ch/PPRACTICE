@extends('layouts.admin')

@section('content')
<div class="admin-title">Добро пожаловать, администратор</div>

<div class="admin-buttons">
    <a href="{{ route('admin.orders') }}" class="btn btn-red">Все заказы</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-red">Все пользователи</a>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-red">Все отзывы</a>
    <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-red">Все заявки</a>
</div>

<h2>Последние заказы</h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Статус</th>
            <th>Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name ?? 'Гость' }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at->format('d.m.Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Последние пользователи</h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Дата регистрации</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d.m.Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Последние отзывы</h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Оценка</th>
            <th>Комментарий</th>
            <th>Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->user_name }} {{ $review->user_surname }}</td>
            <td>{{ $review->rating }}</td>
            <td>{{ Str::limit($review->comment, 50) }}</td>
            <td>{{ $review->created_at->format('d.m.Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2>Последние заявки обратной связи</h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Сообщение</th>
            <th>Дата</th>
        </tr>
    </thead>
    <tbody>
        @foreach($feedbacks as $feedback)
        <tr>
            <td>{{ $feedback->id }}</td>
            <td>{{ $feedback->name }}</td>
            <td>{{ $feedback->email }}</td>
            <td>{{ Str::limit($feedback->message, 50) }}</td>
            <td>{{ $feedback->created_at->format('d.m.Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection