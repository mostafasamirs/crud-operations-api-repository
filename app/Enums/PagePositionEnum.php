<?php

namespace App\Enums;

enum PagePositionEnum: string
{
    case HEADER = 'header';
    case FOOTER = 'footer';
    case BOTH = 'both';

    public function label(): string
    {
        return match ($this) {
            self::HEADER => 'Header',
            self::FOOTER => 'Footer',
            self::BOTH => 'Both',
        };
    }
}
