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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['IN', 'OUT', 'EXPIRED', 'BROKEN', 'OTHERS']);
            $table->text('customer_email');
            $table->text('customer_name');
            $table->decimal('total_amount', 14, 2);
            $table->text('supplier_name');
            $table->text('notes');
            $table->unsignedInteger('created_by_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
