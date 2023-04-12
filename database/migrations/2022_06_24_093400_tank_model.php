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
        Schema::create('tank_model', function (Blueprint $table) {
            $table->id();
            $table->string('modelname')->index();
            $table->string('manufacturer');
            $table->integer('capacity');
            $table->integer('number_of_inserts');
            $table->integer('number_of_tubes');
            $table->integer('number_of_samples');
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tank_model');
    }
};
