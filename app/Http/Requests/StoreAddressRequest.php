<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'label' => ['required', 'string', 'max:255'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:20'],
            'is_default' => ['boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'label.required' => 'Please provide a label for this address (e.g., Home, Work).',
            'address_line_1.required' => 'The street address is required.',
            'address_line_1.max' => 'The street address must not exceed 255 characters.',
            'city.required' => 'The city is required.',
            'zip_code.required' => 'The ZIP code is required.',
            'zip_code.max' => 'The ZIP code must not exceed 20 characters.',
        ];
    }
}
