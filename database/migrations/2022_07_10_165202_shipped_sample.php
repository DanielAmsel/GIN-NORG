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
        Schema::create('shipped_sample', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('responsible_person');
            $table->foreign('responsible_person')->references('email')->on('users')->restrictOnDelete();
            $table->string('type_of_material');
            $table->timestamp('storage_date')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('shipping_date')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('shipped_sample');
    }
};
