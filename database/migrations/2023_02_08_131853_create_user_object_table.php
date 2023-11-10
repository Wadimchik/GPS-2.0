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
        if (!Schema::hasTable('user_object'))
        {
            Schema::create('user_object', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->foreignId('object_id')->constrained();
                $table->boolean('show_on_map')->nullable(false)->default(false);
                $table->timestamps();
                $table->unique(['user_id', 'object_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_object');
    }
};
