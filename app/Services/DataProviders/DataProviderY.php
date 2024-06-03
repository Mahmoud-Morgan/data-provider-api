<?php

namespace App\Services\DataProviders;

use App\Enums\StatusCodeEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DataProviderY implements DataProviderInterface
{
    private $dataProviderYFile = 'storage/app/data/DataProviderY.json';

    public function getData(): array
    {
        $data = File::get($this->dataProviderYFile);
        $users = json_decode($data, true);

        return array_map(function ($user) {
            return [
                'amount' => $user['balance'],
                'currency' => $user['currency'],
                'email' => $user['email'],
                'status' => $this->mapStatusCode($user['status']),
                'created_at' => $this->formatDate($user['created_at']),
                'id' => $user['id'],
                'provider' => 'DataProviderY',
            ];
        }, $users);
    }

    private function mapStatusCode($statusCode): string
    {
        return match ($statusCode) {
            100 => StatusCodeEnum::AUTHORISED->value,
            200 => StatusCodeEnum::DECLINE->value,
            300 => StatusCodeEnum::REFUNDED->value,
            default => 'unknown',
        };
    }

    private function formatDate($dateString): string
    {
        return Carbon::createFromFormat('d/m/Y', $dateString)->format('Y-m-d');
    }

}

