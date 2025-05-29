@extends('layouts.admin')

@section('content')
<div class="order-header">
    <h1>Заказ №{{ $order->id }}</h1>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="order-info">
    <p><strong>Пользователь:</strong> {{ optional($order->user)->name }}</p>
    <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
    <p><strong>Статус:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Всего:</strong> {{ number_format($order->total_price,2) }} ₽</p>
</div>

<h2>Товары</h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Тип</th>
            <th>Кол-во</th>
            <th>Цена шт.</th>
            <th>Сумма</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $i => $item)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $item->project_name }}</td>
            <td>{{ $item->product_type }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price_per_item,2) }} ₽</td>
            <td>{{ number_format($item->price_per_item * $item->quantity,2) }} ₽</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="status-form">
    <h3>Изменить статус</h3>
    <div class="show-forms">
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
            @csrf @method('PATCH')
            <select name="status">
                @foreach(['new','processing','shipped','completed','canceled'] as $st)
                <option value="{{ $st }}" @if($order->status === $st) selected @endif>
                    {{ ucfirst($st) }}
                </option>
                @endforeach
            </select>
            <button type="submit">Обновить</button>
        </form>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
            onsubmit="return confirm('Вы уверены, что хотите удалить этот заказ?');"
            style="margin-top: 15px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-red">Удалить заказ</button>
        </form>
    </div>
</div>


@endsection