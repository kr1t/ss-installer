<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEngineerPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineer_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('engineer_id');
            $table->integer('point');
            $table->bigInteger('redeem_item_id')->nullable();
            $table->bigInteger('engineer_redeem_id')->nullable();
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
        Schema::dropIfExists('engineer_points');
    }
}
