<?php

// Примерная структура реализации корзины в Laravel

/**
 * Этапы реализации корзины и оформления заказа:
 * 1. Хранение корзины (в сессии до входа, в БД после входа).
 * 2. Интерфейс выбора параметров товара (на клиенте).
 * 3. Расчёт стоимости (на клиенте и сервере).
 * 4. Отправка данных на сервер (AJAX или форма).
 * 5. Сохранение в БД в orders и order_items.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Показать содержимое корзины.
     */
    public function index()
    {
        $cart     = session()->get('cart', []);
        $products = Product::with('options')->get();
        return view('layouts.pages.cart', compact('cart', 'products'));
    }

    /**
     * Добавить проект в корзину (в сессию).
     * Ожидает JSON:
     *  - project_name
     *  - project_data (строка JSON с ключами template, preview, date)
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'project_name' => 'required|string|max:255',
            'project_data' => 'required|string',
        ]);

        $parsed = json_decode($data['project_data'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Невалидный JSON'], 422);
        }

        $cart = session()->get('cart', []);

        $cart[] = [
            'name'     => $data['project_name'],
            'template' => $parsed['template'] ?? null,
            'preview'  => $parsed['preview']  ?? null,
            'date'     => now()->format('d.m.Y H:i'),
        ];

        session(['cart' => $cart]);

        return response()->json(['success' => true]);
    }

    /**
     * Очистить корзину (сбросить сессию).
     */
    public function clear(Request $request)
    {
        session()->forget('cart');
        return redirect()->route('cart')
            ->with('success', 'Корзина очищена.');
    }

    /**
     * Оформить заказ: перенести всё из сессии в таблицы orders и order_items.
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')
                ->withErrors('Корзина пуста.');
        }

        // Создаём сам заказ
        $order = Order::create([
            'user_id'     => Auth::id() ?: null,
            'status'      => 'new',
            'total_price' => 0,  // обновим ниже
        ]);

        $totalSum = 0;

        foreach ($cart as $item) {
            $type    = $item['template']['type'] ?? null;
            $product = Product::where('type', $type)->first();

            // Базовая цена
            $basePrice = $product->base_price ?? 0;

            // Здесь можно получить дополнительные параметры из request,
            // но в простой схеме мы их не передаем, поэтому считаем по базовой:
            $pricePerItem = $basePrice;
            $quantity     = 1;

            $subtotal = $pricePerItem * $quantity;
            $totalSum += $subtotal;

            OrderItem::create([
                'order_id'       => $order->id,
                'project_name'   => $item['name'],
                'product_type'   => $type,
                'parameters'     => $item['template'],   // или массив опций
                'quantity'       => $quantity,
                'price_per_item' => $pricePerItem,
            ]);
        }

        // Обновляем итоговую сумму заказа
        $order->update(['total_price' => $totalSum]);

        // Очищаем корзину
        session()->forget('cart');

        return redirect()->route('cart')
            ->with('success', 'Заказ №' . $order->id . ' успешно оформлен.');
    }
}
