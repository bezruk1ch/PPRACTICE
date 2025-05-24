<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // ваша модель товара
use App\Models\Order;   // модель заказа

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'base_type' => 'required|string',
                'parameters' => 'sometimes|array'
            ]);

            $cart = session()->get('cart', []);

            $item = [
                'id' => uniqid(),
                'project_name' => session()->get('project_name', 'Без названия'),
                'product_type' => $validated['base_type'],
                'parameters' => $validated['parameters'],
                'quantity' => 1,
                'price' => $this->calculatePrice(
                    $validated['base_type'],
                    $validated['parameters']
                )
            ];

            session()->put('cart', [...$cart, $item]);

            return redirect()->route('cart.view');
        } catch (\Exception $e) {
            // Логирование ошибки
            \Log::error('Ошибка добавления в корзину: ' . $e->getMessage());

            return back()->withErrors('Произошла ошибка: ' . $e->getMessage());
        }
    }

    public function calculatePrice(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_type' => 'required|string|exists:products,type',
                'selected_options' => 'required|array'
            ]);

            $price = $this->calculateItemPrice(
                $validated['product_type'],
                $validated['selected_options']
            );

            return response()->json([
                'price' => $price,
                'formatted' => number_format($price, 2, ',', ' ') . ' ₽'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ошибка расчета цены: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculateItemPrice($productType, $params)
    {
        try {
            $product = Product::with('options')
                ->where('type', $productType)
                ->firstOrFail();

            $total = $product->base_price;

            foreach ($params as $optionType => $optionValue) {
                $option = $product->options
                    ->where('option_type', $optionType)
                    ->where('option_name', $optionValue)
                    ->first();

                if ($option) {
                    $total += $option->price_modifier;
                }
            }

            return $total;
        } catch (\Exception $e) {
            \Log::error("Price calculation failed for {$productType}: " . $e->getMessage());
            throw new \Exception("Невозможно рассчитать стоимость");
        }
    }
}
