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
        Schema::create('operation_types', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
        });
        DB::table('operation_types')->insert(
            [
                ['name'=>'dailypay', 'type'=>'dailypay'], 
                ['name'=>'Зачислить на счёт', 'type'=>'add_to_balance'], 
                ['name'=>'Монтаж АТ', 'type'=>'montaj_at'],
                ['name'=>'Уведомление по СМС', 'type'=>'sms'],
                ['name'=>'Пополнение счёта', 'type'=>'balance_increase'],
                ['name'=>'Yandex касса', 'type'=>'yandex'],
                ['name'=>'Снять со счёта', 'type'=>'remove_from_balance'],
            ],
        );
        DB::statement('ALTER TABLE operation_types ADD CONSTRAINT chk_type CHECK (type in ("dailypay", "add_to_balance", "montaj_at", "sms", "balance_increase", "yandex", "remove_from_balance"))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_types');
    }
};
