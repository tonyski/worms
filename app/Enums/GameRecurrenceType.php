<?php

namespace App\Enums;

enum GameRecurrenceType: string
{
        // 单次
    case SINGLE = '单次';
        // 每天
    case DAILY = '每天';
        // 每周
    case WEEKLY = '每周';
        // 每月
    case MONTHLY = '每月';
}
