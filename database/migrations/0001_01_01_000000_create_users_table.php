<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('openid')->unique()->comment('微信用户唯一标识');
            $table->string('nickname')->comment('用户昵称');
            $table->string('avatar')->comment('用户头像URL');
            $table->string('session_key')->comment('微信 session_key');
            $table->string('name')->nullable()->comment('用户姓名');
            $table->string('phone')->nullable()->comment('用户手机号');
            $table->tinyInteger('gender')->default(0)->comment('用户性别');
            $table->string('emergency_phone')->nullable()->comment('紧急联系人电话');
            $table->text('introduction')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
