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
        Schema::create('tracker', function (Blueprint $table) {
            $table->id();
            $table->char('imei', 16)->nullable();
            $table->dateTime('time')->nullable();
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->double('speed')->nullable();
            $table->integer('sats')->nullable();
            $table->integer('height')->nullable();
            $table->double('course')->nullable();
            $table->double('temp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker');
    }
};
