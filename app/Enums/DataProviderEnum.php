<?php

namespace App\Enums;

enum DataProviderEnum: string
{
    case DATA_PROVIDER_X = 'DataProviderX';
    case DATA_PROVIDER_Y = 'DataProviderY';

    public static function getProviders(): array
    {
        return array_column(self::cases(), 'value');
    }
}

