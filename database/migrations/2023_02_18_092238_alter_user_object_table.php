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
        if (!Schema::hasColumn('user_object', 'show_in_list'))
        {
            Schema::table('user_object', function (Blueprint $table) {
                $table->boolean('show_in_list')->nullable()->default(true);
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
        if (Schema::hasColumn('user_object', 'show_in_list'))
        {
            Schema::dropColumns('user_object', 'show_in_list');
        }
    }
};
