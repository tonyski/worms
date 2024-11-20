<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class WechatAuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
            'nickname' => 'required|string',
            'avatar' => 'required|string',
        ]);

        // 请求微信服务器获取 openid 和 session_key
        $response = Http::get('https://api.weixin.qq.com/sns/jscode2session', [
            'appid' => env('WECHAT_APP_ID'),
            'secret' => env('WECHAT_APP_SECRET'),
            'js_code' => $validated['code'],
            'grant_type' => 'authorization_code',
        ]);

        $wechatData = $response->json();

        if (!isset($wechatData['openid']) || !isset($wechatData['session_key'])) {
            return response()->json(['error' => '微信登录失败'], 401);
        }

        // 查找或创建用户
        $user = User::updateOrCreate(
            ['openid' => $wechatData['openid']],
            [
                'nickname' => $validated['nickname'],
                'avatar' => $validated['avatar'],
                'session_key' => $wechatData['session_key'],
                'last_login_at' => now(),
            ]
        );

        // 为用户生成 Sanctum Token
        $token = $user->createToken('wechat-mini-app')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }
}
