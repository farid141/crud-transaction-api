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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name')->unique();
            $table->decimal('price', 14, 2);
            $table->enum('unit', ['pcs', 'kilogram', 'mililiter', 'liter', 'gram', 'ton']);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('created_by_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
