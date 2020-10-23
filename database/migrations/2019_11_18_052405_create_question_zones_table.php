<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('zone_id');
            $table->integer('points');
            $table->integer('ques_id');
            $table->string('user_answer');
            $table->integer('hint_id');
            $table->integer('hint_used')->default(0);
            $table->integer('task_completed')->default(0);
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
        Schema::dropIfExists('question_zones');
    }
}
