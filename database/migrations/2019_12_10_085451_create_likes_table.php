<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->integer('article_id')->default(0)->comment('文章ID');
            $table->integer('comment_id')->default(0)->comment('评论ID');
            $table->tinyInteger('like_type')->default(0)->comment('点赞类型(1: 文章 | 2: 评论 | 3: 运动)');

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
        Schema::dropIfExists('likes');
    }
}
