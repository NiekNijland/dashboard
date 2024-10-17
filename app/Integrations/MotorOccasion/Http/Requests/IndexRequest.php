<?php

namespace App\Integrations\MotorOccasion\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<int, mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand' => ['string'],
            'model' => [Rule::requiredIf(fn () => $this->has('brand')), 'string'],
        ];
    }
}
