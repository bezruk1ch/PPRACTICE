@extends('layouts.admin')

@section('content')
  <h1 class="admin-title">Пользователи</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <table class="users-table">
    <thead>
      <tr>
        <th>ID</th><th>Имя</th><th>Логин</th><th>Email</th><th>Роль</th><th>Дата рег.</th><th>Действия</th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->login }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ ucfirst($user->role) }}</td>
        <td>{{ $user->created_at->format('d.m.Y') }}</td>
        <td>
          <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-gray">Ред.</a>
          @if(auth()->id() !== $user->id)
          <form action="{{ route('admin.users.destroy',$user) }}" method="POST"
                style="display:inline" onsubmit="return confirm('Удалить пользователя?')" class="user-form">
            @csrf @method('DELETE')
            <button class="btn btn-red">Удалить</button>
          </form>
          @endif
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

  {{ $users->links() }}
@endsection
