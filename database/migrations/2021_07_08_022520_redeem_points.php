<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedeemPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeem_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id');
            $table->string('jobs_create_date');
            $table->string('jobs_update_date');
            $table->integer('point');
            $table->integer('engineer_id');
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
        //
    }
}
