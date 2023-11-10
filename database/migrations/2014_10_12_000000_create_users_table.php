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
            $table->string('password');
            $table->integer('change_password')->default(0);
            $table->text("comment")->nullable();
            $table->string('phone')->nullable();
            $table->integer("account")->nullable();
            $table->integer("role");
            $table->integer("block")->default(0);
            $table->text("reason_block")->nullable();
            $table->dateTime("last_login")->nullable();
            $table->dateTime("last_action")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
