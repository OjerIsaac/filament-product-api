<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'category' => 'required|string',
            'status' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'The category field is required.',
            'name.required' => 'The name field is required.',
        ];
    }

    /**
     * Define body parameters for API documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the product',
                'example' => 'Laptop'
            ],
            'category' => [
                'description' => 'The category of the product',
                'example' => 'Electronics'
            ],
            'status' => [
                'description' => 'Availability status of the product (true for available, false for unavailable)',
                'example' => true
            ]
        ];
    }
}
