<?php

namespace App\Enums;

enum GameRegistrationStatus: string
{
        // 未知
    case UNKNOWN = '未知';
        // 报名
    case REGISTERED = '已报名';
        // 待定
    case PENDING = '待定';
        // 请假
    case EXCUSED = '请假';
}
