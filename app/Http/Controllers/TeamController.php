<?php

namespace App\Http\Controllers;

use App\Enums\TeamType;
use App\Enums\TeamUserRole;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * 我的团队
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $teams = Team::where('owner_id', auth()->id())->orderByDesc('created_at')->get();
        return $this->respondWithSuccess(TeamResource::collection($teams));
    }

    /**
     * 创建团队
     *
     * @param TeamRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TeamRequest $request)
    {
        // 验证数据
        $data = $request->validated();
        // 创建团队
        $data['owner_id'] = auth()->id();
        $team = Team::create($data);
        // 添加团队管理员
        $team->users()->attach(auth()->id(), [
            'role' => TeamUserRole::OWNER->value,
            'joined_at' => now()
        ]);
        return $this->respondWithSuccess(new TeamResource($team));
    }

    /**
     * 团队详情
     *
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Team $team)
    {
        return $this->respondWithSuccess(new TeamResource($team));
    }

    /**
     * 更新团队
     *
     * @param TeamRequest $request
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TeamRequest $request, Team $team)
    {
        // 验证数据
        $data = $request->validated();
        $team->update($data);
        return $this->respondOk('更新成功');
    }

    /**
     * 删除团队
     *
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return $this->respondOk('删除成功');
    }

    /**
     * 获取所有团队类型
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function types()
    {
        $types = TeamType::cases();
        return $types;
    }

    /**
     * 生成团队专属ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function specialId()
    {
        do {
            // 生成6位随机数
            $specialId = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            // 查询数据库以确保该数字未被使用
            $exists = Team::where('special_id', $specialId)->count();
        } while ($exists > 0);

        return $this->respondWithSuccess([
            'special_id' => $specialId
        ]);
    }
}
