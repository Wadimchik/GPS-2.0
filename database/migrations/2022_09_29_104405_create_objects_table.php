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
        Schema::create('objects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("user_name")->nullable();
            $table->text("comment")->nullable();
            $table->integer("account")->nullable();
            $table->string("type")->nullable();
            $table->string("brand")->nullable();
            $table->string("model")->nullable();
            $table->string("state_number")->nullable();
            $table->string("vin")->nullable();
            $table->string("block")->default(0);
            $table->text("note")->nullable();
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
        Schema::dropIfExists('objects');
    }
};
