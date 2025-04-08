<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DesignTemplate;
use App\Models\UserDesign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ConstructorController extends Controller
{
    /**
     * Главная страница конструктора
     */
    public function index()
    {
        $templates = DesignTemplate::all()->groupBy('type');

        return view('layouts.pages.constructor.index', [
            'templates' => $templates, // Главная переменная
            'cardTemplates' => $templates->get('business_card', collect()),
            'bookletTemplates' => $templates->get('booklet', collect()),
            'flyerTemplates' => $templates->get('flyer', collect()),
            'user' => Auth::user()
        ]);
    }

    /**
     * Выбор шаблона для редактирования
     */
    public function selectTemplate($type, $id)
    {
        $template = DesignTemplate::where('type', $type)
            ->findOrFail($id);

        return view('layouts.pages.constructor.editor', [
            'template' => $template,
            'user' => Auth::user()
        ]);
    }

    /**
     * Сохранение дизайна
     */
    public function saveDesign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|exists:design_templates,id',
            'design_data' => 'required|json',
            'preview_image' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $previewPath = $this->savePreviewImage($request->preview_image);

            $design = UserDesign::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'template_id' => $request->template_id,
                    'status' => 'draft'
                ],
                [
                    'design_data' => $request->design_data,
                    'preview_image' => $previewPath
                ]
            );

            return response()->json([
                'success' => true,
                'design_id' => $design->id,
                'preview_url' => Storage::url($previewPath),
                'redirect' => route('constructor.preview', $design->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сохранения: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Просмотр сохраненного дизайна
     */
    public function previewDesign($id)
    {
        $design = UserDesign::with(['template', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('layouts.pages.constructor.preview', [
            'design' => $design,
            'user' => Auth::user()
        ]);
    }

    /**
     * Отправка на печать
     */
    public function sendToPrint(Request $request, $id)
    {
        $design = UserDesign::where('user_id', Auth::id())
            ->findOrFail($id);

        $design->update(['status' => 'for_print']);

        return redirect()->route('constructor.index')
            ->with('success', 'Ваш заказ #' . $id . ' отправлен в печать!');
    }

    /**
     * Вспомогательная функция для сохранения превью
     */
    private function savePreviewImage($base64Image)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
            throw new \InvalidArgumentException('Некорректный формат изображения');
        }

        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        $fileName = 'designs/previews/' . Str::uuid() . '.png';

        Storage::disk('public')->put($fileName, $imageData);

        return $fileName;
    }

    /**
     * Загрузка списка шаблонов по типу (AJAX)
     */
    public function getTemplatesByType($type)
    {
        $templates = DesignTemplate::where('type', $type)
            ->get(['id', 'name', 'thumbnail', 'description']);

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }
}
