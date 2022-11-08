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
        Schema::create('storage_tank', function (Blueprint $table) {
            $table->id();
            $table->string('modelname');
            $table->string('tank_name');
            $table->unique('tank_name');
            $table->foreign('modelname')->references('modelname')->on('tank_model');
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
        Schema::dropIfExists('storage_tank');
    }
};
