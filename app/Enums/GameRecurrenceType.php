<?php

namespace App\Enums;

enum GameRecurrenceType: string
{
        // 单次
    case SINGLE = 'single';
        // 每天
    case DAILY = 'daily';
        // 每周
    case WEEKLY = 'weekly';
        // 每月
    case MONTHLY = 'monthly';
}
