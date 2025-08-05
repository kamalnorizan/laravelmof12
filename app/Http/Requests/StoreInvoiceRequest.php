<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'status' => 'required|in:unpaid,paid',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'The customer name is required.',
            'customer_email.required' => 'The customer email is required.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either unpaid or paid.',
        ];
    }
}
