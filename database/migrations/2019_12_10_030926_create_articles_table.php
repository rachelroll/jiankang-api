<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title')->default('')->comment('标题');
            $table->string('cover')->default('')->comment('封面图');
            $table->text('content')->comment('内容');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->bigInteger('views_count')->default(0)->comment('浏览量');
            $table->bigInteger('comments_count')->default(0)->comment('评论量');
            $table->bigInteger('likes_count')->default(0)->comment('点赞量');

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
        Schema::dropIfExists('articles');
    }
}
