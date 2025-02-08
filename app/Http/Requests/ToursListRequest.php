<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ToursListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price_from' => 'numeric',
            'price_to' => 'numeric',
            'date_from' => 'date',
            'date_to' => 'date',
            'sort_by' => Rule::in(['price']),
            'sort_order' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages()
    {
        return [
            'sort_by' => 'sort_by accepts only price',
            'sort_order' => 'sort_order accepts only asc or desc',
        ];
    }
}
