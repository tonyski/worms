<?php

namespace App\Enums;

enum TeamUserRole: string
{
        // 队长
    case OWNER = '队长';
        // 副队长
    case MANAGER = '副队长';
        // 成员
    case MEMBER = '成员';
}
