<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('nickname')->default('')->comment('昵称');
            $table->string('avatar')->default('')->comment('头像');
            $table->string('role')->default('')->comment('角色 0: 不可发布 | 1: 可发布');
            $table->string('gender')->default('')->comment('性别 0: 男 | 1: 女');
            $table->string('phone')->default('')->comment('手机号');
            $table->string('openid')->default('')->comment('openid');
            $table->string('unionid')->default('')->comment('unionid');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
