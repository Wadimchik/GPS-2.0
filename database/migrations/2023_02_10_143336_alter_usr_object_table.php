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
        if (!Schema::hasColumn('user_object', 'target_on'))
        {
            Schema::table('user_object', function (Blueprint $table) {
                $table->boolean('target_on')->nullable()->default(false);
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
        if (Schema::hasColumn('user_object', 'target_on'))
        {
            Schema::dropColumns('user_object', 'target_on');
        }
    }
};
