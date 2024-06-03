<?php

namespace App\Enums;

enum StatusCodeEnum: string
{
    case AUTHORISED = 'authorised';
    case DECLINE = 'decline';
    case REFUNDED = 'refunded';


    public static function getStatusCodes(): array
    {
        return array_column(self::cases(), 'value');
    }
}
