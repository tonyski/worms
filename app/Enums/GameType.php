<?php

namespace App\Enums;

enum GameType: string
{
        // 训练（内部）
    case INTERNAL = '对内训练';
        // 对战（对战）
    case EXTERNAL = '组队竞技';
}
