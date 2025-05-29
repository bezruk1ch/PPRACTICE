@extends('layouts.admin')

@section('content')
    <h1 class="admin-title">Заказы</h1>

    @if($orders->count())
        <table>
            <thead>
                <tr>
                    <th>ID заказа</th>
                    <th>Имя клиента</th>
                    <th>Дата оформления</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ optional($order->user)->name ?? 'Гость' }}</td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-gray">Подробнее</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}
    @else
        <p>Заказов пока нет.</p>
    @endif
@endsection
