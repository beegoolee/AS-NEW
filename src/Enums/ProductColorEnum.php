<?php

namespace App\Enums;

enum ProductColorEnum: string
{
    case RED = "красный";
    case YELLOW = "желтый";
    case GREEN = "зеленый";
    case BLACK = "черный";
    case WHITE = "белый";

    public static function getCases(): array
    {
        return self::cases();
    }
}
