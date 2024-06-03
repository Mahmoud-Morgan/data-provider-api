<?php

namespace App\Services\DataProviders;

use App\Enums\StatusCodeEnum;
use Illuminate\Support\Facades\File;

class DataProviderX implements DataProviderInterface
{
    private $dataProviderXFile = 'storage/app/data/DataProviderX.json';

    public function getData(): array
    {
        $data = File::get($this->dataProviderXFile);
        $users = json_decode($data, true);

        return array_map(function ($user) {
            return [
                'amount' => $user['parentAmount'],
                'currency' => $user['Currency'],
                'email' => $user['parentEmail'],
                'status' => $this->mapStatusCode($user['statusCode']),
                'created_at' => $user['registerationDate'],
                'id' => $user['parentIdentification'],
                'provider' => 'DataProviderX',
            ];
        }, $users);
    }

    private function mapStatusCode($statusCode): string
    {
        return match ($statusCode) {
            1 => StatusCodeEnum::AUTHORISED->value,
            2 => StatusCodeEnum::DECLINE->value,
            3 => StatusCodeEnum::REFUNDED->value,
            default => 'unknown',
        };
    }
}

