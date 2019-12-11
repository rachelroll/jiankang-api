<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('step_number')->default(0)->comment('实际步数');
            $table->integer('target_step')->default(0)->comment('目标步数');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->integer('likes_count')->default(0)->comment('点赞量');
            $table->string('date')->default('')->comment('日期');

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
        Schema::dropIfExists('steps');
    }
}
