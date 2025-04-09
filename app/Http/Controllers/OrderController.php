<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Template;

class OrderController extends Controller
{
    // Метод для загрузки страницы с конструктором
    public function create($template_id)
    {
        $template = Template::findOrFail($template_id);
        return view('layouts.pages.constructor.create', compact('template'));
    }

    // Метод для сохранения заказа
    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Создание нового заказа
        $order = new Order();
        $order->user_id = auth()->id();
        $order->template_id = $request->template_id;
        $order->title = $request->title;
        $order->description = $request->description;

        // Сохранение изображения, если оно есть
        if ($request->hasFile('image')) {
            $order->image_path = $request->file('image')->store('uploads', 'public');
        }

        // Статус по умолчанию
        $order->status = 'new';
        $order->save();

        // Перенаправление с сообщением об успехе
        return redirect()->route('constructor.index')->with('success', 'Заказ успешно создан!');
    }
}
