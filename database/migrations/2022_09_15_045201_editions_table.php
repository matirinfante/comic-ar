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
        Schema::create('editions', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('publisher'); //might refer to a list of publishers?
            $table->string('language');
            $table->enum('format', ['Rustica/TPB (tapa blanda)', 'Grapa', 'Tapa dura', 'Bolsillo']);
            $table->boolean('isStandalone');
            $table->boolean('isClosed')->default(false);
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editions');
    }
};
