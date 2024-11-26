<?php

namespace App\Http\Controllers;

use App\Enums\TeamApplicationStatus;
use App\Enums\TeamType;
use App\Enums\TeamUserRole;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    /**
     * 我的团队
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // 我加入的团队
        $teams = auth()->user()->teams()->orderBy('created_at', 'desc')->get();
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
        return $this->respondWithSuccess(new TeamResource($team->load([
            'users',
            'applications' => function ($query) {
                $query->wherePivot('status', TeamApplicationStatus::PENDING->value);
            },
            'games'
        ])));
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

    /**
     * 申请加入团队
     *
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function join(Team $team)
    {
        $message = request('message', '');
        $team->applications()->attach(auth()->id(), [
            'status' => TeamApplicationStatus::PENDING->value,
            'message' => $message
        ]);
        return $this->respondOk('申请成功');
    }

    /**
     * 批准加入团队
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinApprove(Team $team, User $user)
    {
        $team->applications()->updateExistingPivot($user->id, [
            'status' => TeamApplicationStatus::APPROVED->value
        ]);
        $team->users()->attach($user->id, [
            'role' => TeamUserRole::MEMBER->value,
            'joined_at' => now()
        ]);
        return $this->respondOk('审核批准成功');
    }

    /**
     * 审核拒绝团队
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinReject(Team $team, User $user)
    {
        $team->applications()->updateExistingPivot($user->id, [
            'status' => TeamApplicationStatus::REJECTED->value
        ]);
        return $this->respondOk('审核拒绝成功');
    }

    /**
     * 退出团队
     *
     * @param Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function leave(Team $team)
    {
        // 如果是拥有者不能退出
        if ($team->owner_id === auth()->id()) {
            return $this->respondError('拥有者不能退出团队');
        }
        $team->users()->detach(auth()->id());
        return $this->respondOk('退出成功');
    }

    /**
     * 移除成员
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUser(Team $team, User $user)
    {
        // 不能移除自己
        if ($user->id === auth()->id()) {
            return $this->respondError('不能移除自己');
        }
        // 不能移除拥有者
        if ($team->owner_id === $user->id) {
            return $this->respondError('不能移除拥有者');
        }
        $team->users()->detach($user->id);
        return $this->respondOk('移除成功');
    }
}
