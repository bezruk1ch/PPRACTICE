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
        Schema::create('design_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // business_card, booklet, flyer
            $table->string('thumbnail');
            $table->json('structure'); // JSON с описанием полей
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_templates');
    }
};
