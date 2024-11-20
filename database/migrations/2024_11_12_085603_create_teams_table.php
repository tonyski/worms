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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('团队类型');
            $table->string('special_id')->unique()->comment('团队专属ID');
            $table->unsignedBigInteger('owner_id')->comment('团队所有者ID');
            $table->string('name')->comment('团队名称');
            $table->string('color')->nullable()->comment('队服颜色');
            $table->string('province')->comment('省份代码');
            $table->string('city')->comment('城市代码');
            $table->string('area')->comment('区域代码');
            $table->text('description')->nullable()->comment('团队简介');
            $table->boolean('is_public')->default(false)->comment('是否公开');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->comment('团队ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID'); // 用户 ID
            $table->string('role')->comment('角色');
            $table->timestamp('joined_at')->comment('加入时间');
        });

        Schema::create('team_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->comment('团队ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->string('status')->comment('状态');
            $table->text('message')->nullable()->comment('申请理由');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('team_applications');
    }
};
