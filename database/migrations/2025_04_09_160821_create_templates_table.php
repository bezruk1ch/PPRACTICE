<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название шаблона
            $table->string('font')->nullable(); // Шрифт
            $table->string('background_color')->nullable(); // Цвет фона
            $table->string('text_color')->nullable(); // Цвет текста
            $table->string('image')->nullable(); // Изображение (если нужно)
            $table->text('description')->nullable(); // Описание шаблона
            $table->foreignId('category_id')->constrained('categories'); // Связь с категорией
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
};
