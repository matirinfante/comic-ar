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
        Schema::create('objective_volume',function(Blueprint $table){
            $table->foreignId('objective_id')->constrained();
            $table->foreignId('volume_id')->constrained();
            $table->enum('status',['Por leer','Leyendo','Leido']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objective_volume');
    }
};
