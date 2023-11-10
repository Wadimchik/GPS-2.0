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
        Schema::create('user_object_list_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained();
            $table->boolean('show_on_map_action_is_visible')->nullable(false)->default(true);
            $table->boolean('object_name_is_visible')->nullable(false)->default(true);
            $table->boolean('object_state_info_is_visible')->nullable(false)->default(true);
            $table->boolean('last_message_info_is_visible')->nullable(false)->default(true);
            $table->boolean('target_on_action_is_visible')->nullable(false)->default(true);
            $table->boolean('sleep_object_messages_is_visible')->nullable(false)->default(false);
            $table->boolean('radio_bookmarks_is_visible')->nullable(false)->default(false);
            $table->boolean('objects_managing_is_visible')->nullable(false)->default(true);
            $table->boolean('reports_is_visible')->nullable(false)->default(true);
            $table->boolean('objects_settings_is_visible')->nullable(false)->default(true);
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
        Schema::dropIfExists('user_object_list_settings');
    }
};
