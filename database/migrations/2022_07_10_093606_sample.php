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
        Schema::create('sample', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('pos_tank_nr');
            $table->foreign('pos_tank_nr')->references('tank_name')->on('storage_tank');
            $table->integer('pos_insert');
            //$table->foreign('pos_insert')->references('pos_insert')->on('tank_model');
            $table->integer('pos_tube');
            //$table->foreign('pos_tube')->references('pos_tube')->on('tank_model');
            $table->integer('pos_smpl');
            //$table->foreign('pos_smpl')->references('pos_sample')->on('tank_model');
            $table->string('responsible_person');
            $table->foreign('responsible_person')->references('email')->on('users')->restrictOnDelete();
            $table->string('type_of_material');
            $table->foreign('type_of_material')->references('type_of_material')->on('material_types');
            $table->string('commentary')->nullable();
            $table->timestamp('storage_date')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('shipping_date')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('removal_date')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['pos_tank_nr', 'pos_insert', 'pos_tube', 'pos_smpl']);
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sample');
    }
};
