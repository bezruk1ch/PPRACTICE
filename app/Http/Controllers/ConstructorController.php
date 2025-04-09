<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ConstructorController extends Controller
{
    // Метод для отображения страницы конструктора
    public function index()
    {
        $categories = Category::all(); // Получаем все категории из базы
        return view('layouts.pages.constructor.index', compact('categories'));
    }

    public function showTemplates($category_id)
    {
        // Получаем категорию по ID
        $category = Category::find($category_id);

        // Получаем все шаблоны для данной категории
        $templates = Template::where('category_id', $category_id)->get();

        return view('layouts.pages.constructor.templates', compact('category', 'templates'));
    }

    public function edit($templateId)
    {
        // Получаем шаблон по ID
        $template = Template::findOrFail($templateId);

        // Возвращаем вид для редактирования шаблона с переданным шаблоном
        return view('layouts.pages.constructor.edit', compact('template'));
    }

    public function update(Request $request, $templateId)
    {
        $template = Template::findOrFail($templateId);

        $template->update([
            'name' => $request->name,
            'description' => $request->description,
            // Дополнительная логика для обновления изображения, если оно было загружено
        ]);

        return redirect()->route('layouts.pages.constructor.templates', ['category' => $template->category_id])
            ->with('success', 'Шаблон успешно обновлен');
    }

    // Сохранение изменений конструктора
    public function save(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        // Валидация
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'required|string|max:255',
            'font' => 'required|string',
            'background_color' => 'required|string',
        ]);

        // Обработка файла (логотипа)
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('logos', 'public');
            $template->image = $logoPath;
        }

        // Обновление данных шаблона
        $template->text = $request->input('text');
        $template->font = $request->input('font');
        $template->background_color = $request->input('background_color');
        $template->save();

        return redirect()->route('layouts.pages.constructor.edit', ['template' => $template->id])->with('success', 'Шаблон обновлен!');
    }
}
