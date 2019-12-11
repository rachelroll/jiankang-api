<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title')->default('')->comment('banner 标题');
            $table->string('picture')->default('')->comment('图片');
            $table->tinyInteger('placement')->default(0)->comment('banner 位置(1: 首页 | 2: 运动 |3: 计划 | 4: 发布)');
            $table->tinyInteger('click_type')->default(0)->comment('跳转类型(1: web | 2: 内容 | 3: 无)');
            $table->string('attachment')->default('')->comment('跳转资源');
            $table->string('start_time')->default('')->comment('上架时间');
            $table->string('end_time')->default('')->comment('下架时间');

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
        Schema::dropIfExists('banners');
    }
}
