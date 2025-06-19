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
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreatedMail;

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
        /* ───────────────────── 1. ВАЛИДАЦИЯ ───────────────────── */
        $data = $request->validate([
            // выбор способа получения
            'shipping_type'    => 'required|in:delivery,pickup',
            // адрес нужен только при delivery
            'shipping_address' => 'required_if:shipping_type,delivery|string|max:255',
            // оплата
            'payment_method'   => 'required|in:cash,card,online',
            // комментарий не обязателен
            'comment'          => 'nullable|string|max:500',

            // массив позиций из формы
            'items'                => 'required|array',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.options'      => 'array',
            'items.*.options.*'    => 'string|max:100',

        ]);

        /* ───────────────────── 2. ПРОВЕРКА КОРЗИНЫ ───────────────────── */
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('order_error', 'Корзина пуста.');
        }

        $itemsData = $data['items'];   // всё то же, только берём из $data
        $user = Auth::user();

        try {
            /* ───────────────── 3. СОЗДАНИЕ ЗАКАЗА ───────────────── */
            $order = Order::create([
                'user_id'          => Auth::id() ?: null,
                'status'           => 'new',
                'total_price'      => 0,                   // обновим ниже
                'shipping_type'    => $data['shipping_type'],
                'shipping_address' => $data['shipping_address'] ?? null,
                'payment_method'   => $data['payment_method'],
                'comment'          => $data['comment']     ?? null,
                'customer_name'    => $user->name,
                'customer_email'   => $user->email,
                'customer_phone'   => $user->phone ?? '',
            ]);

            $totalSum = 0;

            /* ──────────────── 4. ПЕРЕНОС ПОЗИЦИЙ ──────────────── */
            foreach ($cart as $index => $item) {
                $type    = $item['template']['type'] ?? null;
                $product = Product::where('type', $type)->with('options')->first();
                if (!$product) continue;

                $basePrice = $product->base_price ?? 0;
                $quantity  = (int)($itemsData[$index]['quantity'] ?? 1);
                $options   = $itemsData[$index]['options'] ?? [];

                // модификаторы наценки
                $modifiers = 0;
                foreach ($options as $optType => $optValue) {
                    $opt = $product->options
                        ->where('option_type', $optType)
                        ->where('option_name', $optValue)
                        ->first();
                    $modifiers += $opt?->price_modifier ?? 0;
                }

                $pricePerItem = $basePrice + $modifiers;
                $subtotal     = $pricePerItem * $quantity;
                $totalSum    += $subtotal;

                OrderItem::create([
                    'order_id'       => $order->id,
                    'project_name'   => $item['name'],
                    'product_type'   => $type,
                    'parameters'     => json_encode($options, JSON_UNESCAPED_UNICODE),
                    'quantity'       => $quantity,
                    'price_per_item' => $pricePerItem,
                ]);
            }

            /* ─────────────────── 5. ИТОГО ─────────────────── */
            $order->update(['total_price' => $totalSum]);

            session()->forget('cart');

            return redirect()->route('cart')
                ->with('order_success', "Заказ успешно оформлен 🎉 Уведомление отправлено на {$order->customer_email}");
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('cart')->with('order_error', 'Произошла ошибка при оформлении заказа. Попробуйте снова.');
        }
    }
}
