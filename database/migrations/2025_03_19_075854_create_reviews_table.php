<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Оставляем nullable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Если user_id отсутствует, оставляем его пустым
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->text('comment');
            $table->timestamps();
            $table->string('user_avatar')->nullable(); // Дополнительный столбец для аватара
            $table->boolean('is_company')->default(false); // Флаг для компаний, если нужно
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
