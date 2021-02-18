<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name_th');
            $table->string('last_name_th');
            $table->string('first_name_en');
            $table->string('last_name_en');
            $table->string('email');
            $table->string('tel');
            $table->tinyInteger('type_of_work');
            $table->string('shop')->nullable();
            $table->string('province');
            $table->string('history_install');
            $table->string('month');
            $table->string('line_uid');
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
        Schema::dropIfExists('engineers');
    }
}
