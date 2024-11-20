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
        // 比赛模板
        Schema::create('game_templates', function (Blueprint $table) {
            $table->id();
            $table->string('game_name')->comment('比赛名称');
            $table->unsignedBigInteger('team_id')->comment('所属团队ID');
            $table->string('type')->comment('比赛类型');
            $table->string('location')->comment('比赛地点');
            $table->integer('max_players')->nullable()->comment('最大人数');
            $table->time('start_time')->comment('比赛开始时间');
            $table->time('end_time')->nullable()->comment('比赛结束时间');
            $table->string('recurrence_type')->comment('重复类型');
            $table->string('recurrence')->nullable()->comment('重复规则');
            $table->text('description')->nullable()->comment('比赛描述');
            $table->boolean('is_enabled')->default(false)->comment('是否开启');
            $table->timestamps();
            $table->softDeletes();
        });

        // 比赛
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('比赛类型');
            $table->unsignedBigInteger('team_id')->comment('举办团队ID');
            $table->date('date')->comment('比赛日期');
            $table->json('template_info')->comment('模版信息');
            $table->text('remark')->nullable()->comment('备注');
            $table->timestamps();
        });

        // 如果是外部对抗比赛，需要关联其他团队
        Schema::create('game_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->comment('比赛ID');
            $table->unsignedBigInteger('team_id')->comment('参赛团队ID');
            $table->timestamps();
        });

        // 比赛报名
        Schema::create('game_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->comment('比赛ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->string('status')->comment('报名状态');
            $table->boolean('is_present')->default(false)->comment('是否到场');
            $table->text('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_templates');
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_team');
        Schema::dropIfExists('game_registrations');
    }
};
