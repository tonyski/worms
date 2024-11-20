<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameTemplateController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WechatAuthController;
use Illuminate\Support\Facades\Route;

Route::post('wechat/login', [WechatAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // 用户
    Route::prefix('users')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
    });

    // 团队
    Route::prefix('teams')->group(function () {
        // 获取所有团队类型
        Route::get('/types', [TeamController::class, 'types']);
        // 生成团队专属ID
        Route::get('/special_id', [TeamController::class, 'specialId']);
        // 增删改查
        Route::get('/', [TeamController::class, 'index']);
        Route::post('/', [TeamController::class, 'store']);
        Route::get('/{team}', [TeamController::class, 'show']);
        Route::put('/{team}', [TeamController::class, 'update']);
        Route::delete('/{team}', [TeamController::class, 'destroy']);

        // 申请加入
        Route::post('/{team}/join', [TeamController::class, 'join']);
        // 同意加入
        Route::post('/{team}/join/{user}', [TeamController::class, 'joinAccept']);
        // 退出团队
        Route::delete('/{team}/leave', [TeamController::class, 'leave']);
    });

    // 比赛
    Route::prefix('games')->group(function () {
        // 模版
        Route::get('/templates', [GameTemplateController::class, 'index']);
        Route::get('/templates/{template}', [GameTemplateController::class, 'show']);
        Route::post('/templates', [GameTemplateController::class, 'store']);
        Route::put('/templates', [GameTemplateController::class, 'update']);
        Route::delete('/templates', [GameTemplateController::class, 'destroy']);

        // 发起
        Route::post('/', [GameController::class, 'store']);
    });
});
