@extends('layouts.admin')

@section('content')
<h1 class="admin-title">Редактировать отзыв</h1>

<form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="review-form">
    @csrf
    @method('PUT')

    <label>
        <span>Имя:</span>
        <input type="text" name="user_name" value="{{ old('user_name', $review->user_name) }}">
    </label>

    <label>
        <span>Фамилия:</span>
        <input type="text" name="user_surname" value="{{ old('user_surname', $review->user_surname) }}">
    </label>

    <label>
        <span>Оценка (1-5):</span>
        <input type="number" name="rating" min="1" max="5" value="{{ old('rating', $review->rating) }}">
    </label>

    <label>
        <span>Комментарий:</span>
        <textarea name="comment">{{ old('comment', $review->comment) }}</textarea>
    </label>

    <label class="review-checkbox">
        <input type="checkbox" name="is_for_main_page" value="1" {{ $review->is_for_main_page ? 'checked' : '' }}>
        Показывать на главной
    </label>

    <div class="review-form-buttons">
        <button type="submit" class="btn">Сохранить</button>
    </div>
</form>
@endsection