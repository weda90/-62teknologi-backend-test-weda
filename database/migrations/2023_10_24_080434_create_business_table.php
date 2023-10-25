<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('alias');
            $table->string('name');
            $table->string('image_url');
            $table->boolean('is_closed');
            $table->string('url');
            $table->integer('review_count');
            $table->decimal('rating', 3, 1);
            $table->string('price');
            $table->string('phone');
            $table->string('display_phone');
            $table->decimal('distance', 10, 3);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business');
    }
};
