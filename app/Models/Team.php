<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'description',
        'special_id',
        'owner_id',
        'color',
        'province',
        'city',
        'area',
    ];

    /**
     * 关联 team_user 表
     */
    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
            ->withPivot(['role', 'joined_at']);
    }

    /**
     * 关联 team_applications 表
     */
    public function applications()
    {
        return $this
            ->belongsToMany(User::class, 'team_applications', 'team_id', 'user_id')
            ->withPivot(['status', 'message', 'created_at']);
    }

    /**
     * 关联 games 表
     */
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
