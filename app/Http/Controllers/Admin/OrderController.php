<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReadyMail; 


class OrderController extends Controller
{
    // 1) Список заказов
    public function index()
    {
        \Log::info('Admin\OrderController@index called');
        // пагинация позволяет $orders->links() работать
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // 2) Детали заказа
    public function show(Order $order)
    {
        // Загрузим связанные позиции, если нужно
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    // 3) Обновление статуса
    public function updateStatus(Request $request, Order $order)
    {
        /* ── валидация ── */
        $data = $request->validate([
            'status' => 'required|in:new,processing,ready,shipped,completed,canceled',
        ]);

        $previousStatus = $order->status;          // запомним старый
        $order->update(['status' => $data['status']]);

        /* ── письмо клиенту, когда заказ готов ── */
        if ($data['status'] === 'ready' && $previousStatus !== 'ready') {
            Mail::to($order->customer_email)
                ->send(new OrderReadyMail($order));
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Статус заказа обновлён.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders')
            ->with('success', 'Заказ №' . $order->id . ' удалён.');
    }
}
