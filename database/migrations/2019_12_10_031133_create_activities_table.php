<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('activity_name')->default('')->comment('活动名称');
            $table->text('content')->comment('活动详情');
            $table->bigInteger('likes_count')->default(0)->comment('点赞数');
            $table->bigInteger('views_count')->default(0)->comment('阅读量');
            $table->integer('user_id')->default(0)->comment('报名用户ID');

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
        Schema::dropIfExists('activities');
    }
}
