<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'max:9999.99', 'lt:price'],
            'preparation_time' => ['nullable', 'integer', 'min:0', 'max:180'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:3072'],
            'is_available' => ['boolean'],
            'is_featured' => ['boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category for this menu item.',
            'category_id.exists' => 'The selected category is invalid.',
            'name.required' => 'The menu item name is required.',
            'name.max' => 'The menu item name must not exceed 255 characters.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'price.max' => 'The price must not exceed 9999.99.',
            'discount_price.lt' => 'Discount price must be less than the regular price.',
            'preparation_time.max' => 'Preparation time must not exceed 180 minutes.',
            'image.max' => 'Image size must not exceed 3MB.',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, GIF, or WebP file.',
        ];
    }
}
