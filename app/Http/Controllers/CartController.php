<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // ваша модель товара
use App\Models\Order;   // модель заказа

class CartController extends Controller
{
    public function index(Request $req)
    {
        // В простейшем варианте храним корзину в сессии:
        $cart = session()->get('cart', []);
        // $cart = [
        //    product_id => ['qty' => 2, 'product' => Product],
        //    ...
        // ];



        return view('layouts.pages.cart', compact('cart'));
    }

    public function update(Request $req)
    {
        $id  = $req->input('product_id');
        $qty = max(1, (int)$req->input('qty', 1));
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session()->put('cart', $cart);
        }
        return back();
    }

    public function remove(Request $req)
    {
        $id = $req->input('product_id');
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return back();
    }

    public function clear()
    {
        session()->forget('cart');
        return back();
    }

    public function checkout(Request $request)
    {
        $cart = json_decode($request->input('cart'), true);

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Корзина пуста']);
        }

        // Пример базового сохранения заказа (упрости или доработай под свою логику)
        foreach ($cart as $item) {
            \App\Models\Order::create([
                'user_id' => Auth::id(),
                'product_name' => $item['name'] ?? 'Неизвестный товар',
                'quantity' => $item['quantity'] ?? 1,
                'price' => $item['price'] ?? 0,
                'total' => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
                // можно добавить дополнительные поля, например: макет, бумага и т.п.
            ]);
        }

        return response()->json(['success' => true]);
    }
}
