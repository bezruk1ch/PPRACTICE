@extends('layouts.admin')

@section('content')
    <h1 class="admin-title">Отзывы</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="reviews-table">
        <thead>
            <tr>
                <th>Аватар</th>
                <th>Имя</th>
                <th>Оценка</th>
                <th>На главную</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td><img src="{{ $review->avatar_url }}" width="50" height="50" style="border-radius:50%;"></td>
                    <td>{{ $review->user_name }} {{ $review->user_surname }}</td>
                    <td>{{ $review->rating }} ★</td>
                    <td>{{ $review->is_for_main_page ? 'Да' : 'Нет' }}</td>
                    <td>{{ $review->created_at->format('d.m.Y') }}</td>
                    <td>
                        <a href="{{ route('admin.reviews.edit', $review) }}"><button class="btn">Редактировать</button></a>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Удалить отзыв?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
