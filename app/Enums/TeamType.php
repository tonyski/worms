<?php

namespace App\Enums;

enum TeamType: string
{
        // 足球
    case Football = '足球';
        // 篮球
    case Basketball = '篮球';
        // 羽毛球
    case Badminton = '羽毛球';
        // 网球
    case Tennis = '网球';
        // 骑行
    case Riding = '骑行';
        // 其他
    case Other = '其他';
}
