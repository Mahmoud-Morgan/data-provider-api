<?php

namespace App\Services\DataProviders;

use App\Enums\DataProviderEnum;

class DataProviderContext
{
    private $provider;

    public function __construct(DataProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function getData(): array
    {
        return $this->provider->getData();
    }
}
