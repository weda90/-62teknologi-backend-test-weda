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
       Schema::create('coordinates', function (Blueprint $table) {
           $table->string('business_id');
           $table->decimal('latitude', 9, 6);
           $table->decimal('longitude', 9, 6);
           $table->foreign('business_id')
                 ->references('id')
                 ->on('business')
                 ->onDelete('cascade');
       });
   }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinates');
    }
};
