<?php

namespace App\Enums;

enum ItemColor: int
{
    case Red = 1;
    case Green = 2;
    case Blue = 3;
    case Yellow = 4;
    case Orange = 5;
    case Cyan = 6;
    case Magenta = 7;
    case Purple = 8;
    case Pink = 9;
    case White = 10;
    case Black = 11;
    case Grey = 12;
    case Beige = 13;
    case Gold = 14;
    case Brown = 15;

    public static function getColorMap(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
