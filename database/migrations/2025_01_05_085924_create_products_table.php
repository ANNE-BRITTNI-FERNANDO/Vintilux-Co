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
            $table->timestamps();
            $table->string('product_name');
            $table->string('product_description');
            $table->decimal('product_price', 8, 2);
            $table->string('product_size');
            $table->array('product_colors');
            $table->integer('product_quantity');
            $table->string('category_name');
            $table->string('product_image');
            $table->string('product_gallery');
            $table->tinyinteger('product_status')->default(1);
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
