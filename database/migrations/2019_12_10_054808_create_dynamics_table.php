<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('comment_id')->default(0)->comment('评论ID');
            $table->integer('article_id')->default(0)->comment('文章ID');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->tinyInteger('dynamic_type')->default(0)->comment('动态类型(1: 评论 | 2: 发布 | 3: 点赞)');

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
        Schema::dropIfExists('dynamics');
    }
}
