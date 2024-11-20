<?php

namespace App\Enums;

enum TeamUserRole: string
{
        // 队长
    case OWNER = 'owner';
        // 副队长
    case MANAGER = 'manager';
        // 成员
    case MEMBER = 'member';
}
