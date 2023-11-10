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
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropForeign(['object_id']);
            $table->dropUnique('object_id_imei_ui');
            $table->foreign('object_id')->references('id')->on('objects')->onUpdate('cascade')->onDelete('set null');
        });
//        Schema::table('equipment', function (Blueprint $table) {
//            $table
//                ->foreignId('object_id')
//                ->constrained()
//                ->onUpdate('cascade')
//                ->onDelete('set null');
//        });
//        DB::statement('UPDATE `equipment` SET `object_id` = `object`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->unique(['object_id', 'imei'], 'object_id_imei_ui');
        });
    }
};
