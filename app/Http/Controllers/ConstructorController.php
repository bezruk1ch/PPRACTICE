<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class ConstructorController extends Controller
{
    // Метод для отображения страницы конструктора
    public function index()
    {
        // Получаем все шаблоны
        $templates = Template::all();

        // Возвращаем представление конструктора с доступными шаблонами
        return view('layouts.pages.constructor.index', compact('templates'));
    }

    // Метод для загрузки страницы создания заказа
    public function create($template_id)
    {
        $template = Template::findOrFail($template_id);
        return view('layouts.pages.constructor.create', compact('template'));
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::id(); // Получаем ID пользователя
        $order->template_id = $request->template_id; // ID выбранного шаблона
        $order->text = $request->text; // Текст из формы
        if ($request->hasFile('image')) {
            $order->image_path = $request->file('image')->store('uploads', 'public'); // Сохраняем изображение
        }
        $order->status = 'new'; // Статус по умолчанию
        $order->save(); // Сохраняем заказ в базу данных

        return redirect()->route('profile')->with('success', 'Макет успешно создан!'); // Перенаправляем на профиль
    }
}
