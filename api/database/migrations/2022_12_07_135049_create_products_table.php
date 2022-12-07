<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('manufacturer');
            $table->string('price');
            $table->foreignId('categories_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_categories_id')->constrained()->onDelete('cascade');
            $table->string('imageOne');
            $table->string('imageTwo');
            $table->string('imageThree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
