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
            $table->string('first_name_en')->nullable();
            $table->string('last_name_en')->nullable();
            $table->string('email');
            $table->string('tel');
            $table->tinyInteger('type_of_work')->nullable();
            $table->string('shop')->nullable();
            $table->integer('province')->nullable();
            $table->string('province_text')->nullable();
            $table->string('history_install')->nullable();
            $table->string('month')->nullable();
            $table->string('line_uid');
            $table->integer('point')->default(0);
            $table->string('installer_id')->nullable();

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
