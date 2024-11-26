<?php

namespace App\Enums;

enum TeamApplicationStatus: string
{
        // 待审核
    case PENDING = '待审核';
        // 审核通过
    case APPROVED = '通过';
        // 审核拒绝
    case REJECTED = '拒绝';
}
