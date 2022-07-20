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
        Schema::create('positions_inserts', function (Blueprint $table) {
            $table->id();
            $table->integer('pos_insert')->index();

        });
        Schema::create('positions_tubes', function (Blueprint $table) {
            $table->id();
            $table->integer('pos_tube')->index();

        });
        Schema::create('positions_sample', function (Blueprint $table) {
            $table->id();
            $table->integer('pos_sample')->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
};
