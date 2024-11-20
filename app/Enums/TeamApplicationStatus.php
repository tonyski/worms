<?php

namespace App\Enums;

enum TeamApplicationStatus: string
{
        // 待审核
    case PENDING = 'pending';
        // 审核通过
    case APPROVED = 'approved';
        // 审核拒绝
    case REJECTED = 'rejected';
}
