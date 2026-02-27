<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i', 'after:opening_time'],
            'delivery_time' => ['nullable', 'integer', 'min:0', 'max:180'],
            'minimum_order' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'delivery_fee' => ['nullable', 'numeric', 'min:0', 'max:99.99'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The restaurant name is required.',
            'phone.required' => 'A contact phone number is required.',
            'email.required' => 'A contact email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'address.required' => 'The restaurant address is required.',
            'city.required' => 'The city is required.',
            'closing_time.after' => 'Closing time must be after opening time.',
            'delivery_time.max' => 'Delivery time must not exceed 180 minutes.',
            'minimum_order.max' => 'Minimum order must not exceed 999.99.',
            'delivery_fee.max' => 'Delivery fee must not exceed 99.99.',
            'logo.max' => 'Logo size must not exceed 2MB.',
            'cover_image.max' => 'Cover image size must not exceed 5MB.',
        ];
    }
}
