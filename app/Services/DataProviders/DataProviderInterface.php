<?php
namespace App\Services\DataProviders;

interface DataProviderInterface
{
    public function getData(): array;
}
