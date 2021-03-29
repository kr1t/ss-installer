<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEngineerAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineer_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('engineer_id');
            $table->tinyInteger('exam_type');
            $table->smallInteger('score');
            $table->string('answer_1');
            $table->string('answer_2');
            $table->string('answer_3');
            $table->string('answer_4');
            $table->string('answer_5');
            $table->string('answer_6');
            $table->string('answer_7');
            $table->string('answer_8');
            $table->string('answer_9');
            $table->string('answer_10');
            $table->string('answer_11');
            $table->string('answer_12');
            $table->string('answer_13');
            $table->string('answer_14');
            $table->string('answer_15');
            $table->string('answer_16');
            $table->string('answer_17');
            $table->string('answer_18');
            $table->string('answer_19');
            $table->string('answer_20');
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
        Schema::dropIfExists('engineer_answers');
    }
}
