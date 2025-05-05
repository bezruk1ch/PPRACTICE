<h2>Отзывы</h2>
<table>
    <tr>
        <th>Пользователь</th>
        <th>Отзыв</th>
        <th>Оценка</th>
        <th>Действия</th>
    </tr>
    @foreach ($reviews as $review)
        <tr>
            <td>{{ $review->user->name }}</td>
            <td>{{ $review->text }}</td>
            <td>{{ $review->rating }}</td>
            <td><a href="{{ route('admin.reviews.edit', $review) }}">Редактировать</a></td>
        </tr>
    @endforeach
</table>