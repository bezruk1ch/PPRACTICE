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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('template_id')->nullable();
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('set null');

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->string('image_path')->nullable();

            $table->string('product_type')->nullable();       // Тип товара (например, "Визитка")
            $table->string('paper_quality')->nullable();      // Качество бумаги (например, "Премиум")
            $table->string('lamination')->nullable();         // Ламинация (например, "Глянцевая")

            $table->integer('quantity')->default(1);          // Кол-во товара
            $table->decimal('unit_price', 8, 2)->nullable();  // Цена за единицу
            $table->decimal('total_price', 10, 2)->nullable();// Общая цена = unit_price * quantity

            $table->enum('status', ['new', 'in_progress', 'completed', 'canceled'])->default('new');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
