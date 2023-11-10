<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type')->unique();
        });
        DB::statement(
            "ALTER TABLE permissions ADD CONSTRAINT check_permission_type CHECK (
                type IN (
                    'view', 'view-sleeping', 'blocking', 'coordinate', 'reboot', 'property-view', 'property-change',
                    'fuel', 'sensor'
                )
            )"
        );
        DB::table('permissions')->insert(
            [
                ['name' => 'Просмотр', 'type' => 'view'],
                ['name' => 'Просмотр "спящих"', 'type' => 'view-sleeping'],
                ['name' => 'Блокировка', 'type' => 'blocking'],
                ['name' => 'Координаты', 'type' => 'coordinate'],
                ['name' => 'Перезагрузка', 'type' => 'reboot'],
                ['name' => 'Просмотр свойств', 'type' => 'property-view'],
                ['name' => 'Изменение свойств', 'type' => 'property-change'],
                ['name' => 'Топливо', 'type' => 'fuel'],
                ['name' => 'Датчики', 'type' => 'sensor'],
            ],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
