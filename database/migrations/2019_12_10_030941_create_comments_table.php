<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('content')->default('')->comment('评论内容');
            $table->integer('article_id')->default(0)->comment('文章ID');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->integer('parent_id')->default(0)->comment('父ID');
            $table->integer('likes_count')->default(0)->comment('点赞量');

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
        Schema::dropIfExists('comments');
    }
}
