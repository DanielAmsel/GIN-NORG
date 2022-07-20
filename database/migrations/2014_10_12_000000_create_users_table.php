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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->useCurrent()->useCurrentOnUpdate();;
            $table->string('password');
            $table->string('role');
            $table->foreign('role')->references('role_name')->on('roles');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('updated_at')->nullable();
            // TODO: wie updated_at realisieren? //Andi: Versteh ich nicht, warum soll es einen Updated Eintrag für User geben?
            // bsp:
            //$table->timestamp('updated_at');
            // $lastUpdatedUser = User::newest('updated_at')->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
