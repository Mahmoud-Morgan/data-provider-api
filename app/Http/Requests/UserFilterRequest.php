<?php

namespace App\Http\Requests;

use App\Enums\DataProviderEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\StatusCodeEnum;

class UserFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'provider' => 'sometimes|string|in:' . implode(',', DataProviderEnum::getProviders()),
            'statusCode' => 'sometimes|string|in:'. implode(',', StatusCodeEnum::getStatusCodes()),
            'currency' => 'sometimes|string|size:3', // Assuming currency codes are 3 letters
            'balanceMin' => 'sometimes|numeric|min:0',
            'balanceMax' => 'sometimes|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'provider.in' => 'The provider must be either DataProviderX or DataProviderY.',
            'statusCode.in' => 'The status code must be either authorised, decline, or refunded.',
            'currency.size' => 'The currency must be a 3-letter code.',
            'balanceMin.numeric' => 'The minimum balance must be a number.',
            'balanceMax.numeric' => 'The maximum balance must be a number.',
        ];
    }
}
