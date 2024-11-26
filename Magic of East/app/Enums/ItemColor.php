<?php

namespace App\Enums;

enum ItemColor: int
{
    case lightblue = 0;
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
    case lightgreen = 16;

    public static function getColorMap(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
    public static function fromValue(int $value): self
    {
        return match ($value) {
            0 => self::lightblue,
            1 => self::Red,
            2 => self::Green,
            3 => self::Blue,
            4 => self::Yellow,
            5 => self::Orange,
            6 => self::Cyan,
            7 => self::Magenta,
            8 => self::Purple,
            9 => self::Pink,
            10 => self::White,
            11 => self::Black,
            12 => self::Grey,
            13 => self::Beige,
            14 => self::Gold,
            15 => self::Brown,
            16 => self::lightgreen,
            default => throw new \InvalidArgumentException("Invalid color value: $value"),
        };
    }
}
