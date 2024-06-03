<?php

namespace App\Http\Controllers;

use App\Enums\DataProviderEnum;
use App\Http\Requests\UserFilterRequest;
use Illuminate\Http\JsonResponse;
use App\Services\DataProviders\DataProviderContext;
use App\Services\DataProviders\DataProviderX;
use App\Services\DataProviders\DataProviderY;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index(UserFilterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $providerParam = $validated['provider'] ?? null;
        $status = $validated['statusCode'] ?? null;
        $currency = $validated['currency'] ?? null;
        $balanceMin = $validated['balanceMin'] ?? null;
        $balanceMax = $validated['balanceMax'] ?? null;

        $providers = collect([]);

        if (!$providerParam || $providerParam == DataProviderEnum::DATA_PROVIDER_X->value) {
            $providers = $providers->merge((new DataProviderContext(new DataProviderX()))->getData());        }
        if (!$providerParam || $providerParam == DataProviderEnum::DATA_PROVIDER_Y->value) {
            $providers = $providers->merge((new DataProviderContext(new DataProviderY()))->getData());
        }
        $users = collect([]);

        $providers->chunk(1000)->each(function ($chunk) use ($status, $currency, $balanceMin, $balanceMax, &$users) {
            $filteredChunk = $this->applyFilters($chunk, $status, $currency, $balanceMin, $balanceMax);
            $users = $users->merge($filteredChunk);
        });

        return response()->json($users);
    }

    private function applyFilters(Collection $users, $status, $currency, $balanceMin, $balanceMax): Collection
    {
        return $users->filter(function ($user) use ($status, $currency, $balanceMin, $balanceMax) {
            if ($status && $user['status'] != $status) {
                return false;
            }
            if ($currency && $user['currency'] != $currency) {
                return false;
            }
            if ($balanceMin && $user['amount'] < $balanceMin) {
                return false;
            }
            if ($balanceMax && $user['amount'] > $balanceMax) {
                return false;
            }
            return true;
        });
    }
}
