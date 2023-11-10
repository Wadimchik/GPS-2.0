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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("comment")->nullable();
            $table->string("full_name")->nullable();
            $table->integer("tariff");
            $table->float("balance")->default(0);
            $table->integer("pay_method");
            $table->float("limit_debt");
            $table->integer("limit_debt_type");
            $table->integer("block")->default(0);
            $table->text("reason_block")->nullable();
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
        Schema::dropIfExists('account');
    }
};
