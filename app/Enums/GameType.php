<?php

namespace App\Enums;

enum GameType: string
{
        // 训练（内部）
    case INTERNAL = 'internal';
        // 对战（对战）
    case EXTERNAL = 'external';
}
