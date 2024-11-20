<?php

namespace App\Enums;

enum GameRegistrationStatus: string
{
        // 未知
    case UNKNOWN = 'unknown';
        // 报名
    case REGISTERED = 'registered';
        // 待定
    case PENDING = 'pending';
        // 请假
    case EXCUSED = 'excused';
}
