<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEngineerRedeemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineer_redeems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('engineer_id');
            $table->string('name');
            $table->string('address');
            $table->string('tel');
            $table->bigInteger('redeem_item_id');
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
        Schema::dropIfExists('engineer_redeems');
    }
}
