@extends('layouts.admin')

@section('content')
<h2>Все заявки обратной связи</h2>

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
            <td>{{ Str::limit($feedback->message, 70) }}</td>
            <td>{{ $feedback->created_at->format('d.m.Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $feedbacks->links() }}
@endsection
