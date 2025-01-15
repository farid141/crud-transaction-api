<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('uuid')->nullable(); // Changed from uuid to string
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->text('manipulations'); // Changed from json to text
            $table->text('custom_properties'); // Changed from json to text
            $table->text('generated_conversions'); // Changed from json to text
            $table->text('responsive_images'); // Changed from json to text
            $table->unsignedInteger('order_column')->nullable();

            $table->nullableTimestamps();
        });
    }
};
