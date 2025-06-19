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

            /* данные клиента */
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name', 100);
            $table->string('customer_email');
            $table->string('customer_phone', 30);

            /* статус и суммы */
            $table->string('status')->default('new');
            $table->decimal('total_price', 10, 2)->default(0);

            /* доставка / оплата */
            $table->enum('shipping_type', ['delivery', 'pickup'])->default('delivery');
            $table->string('shipping_address')->nullable();
            $table->enum('payment_method', ['cash', 'card', 'online'])->default('cash');

            /* прочее */
            $table->text('comment')->nullable();

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
