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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity');
            $table->decimal('total_amount', 14, 2);
            $table->unsignedInteger('quantity_before');
            $table->unsignedInteger('quantity_after');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('created_by_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
