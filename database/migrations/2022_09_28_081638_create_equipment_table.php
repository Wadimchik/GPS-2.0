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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            $table->string("owner")->nullable();
            $table->string("reason_use")->nullable();
            $table->date("date_sale")->nullable();
            $table->string("work")->nullable();
            $table->date("date_work")->nullable();
            $table->text("comment")->nullable();
            $table->integer("account");

            $table->integer("type");
            $table->integer("brand")->nullable();
            $table->integer("model")->nullable();
            $table->string("serial_number")->nullable();
            $table->string("imei")->nullable();
            $table->string("login")->nullable();
            $table->string("password")->nullable();
            $table->string("firmware")->nullable();
            $table->string("config")->nullable();

            $table->string("sim_owner")->nullable();
            $table->string("sim_operator")->nullable();
            $table->string("sim_number")->nullable();
            $table->string("sim_iccid")->nullable();
            $table->string("sim_comment")->nullable();

            $table->string("installation_location")->nullable();

            $table->integer("object")->nullable();

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
        Schema::dropIfExists('equipment');
    }
};
