<h2>Редактирование отзыва</h2>
<form action="{{ route('admin.reviews.update', $review) }}" method="POST">
    @csrf
    <label>Текст:</label>
    <textarea name="text">{{ $review->text }}</textarea>
    <label>Оценка:</label>
    <input type="number" name="rating" min="1" max="5" value="{{ $review->rating }}">
    <button type="submit">Сохранить</button>
</form>