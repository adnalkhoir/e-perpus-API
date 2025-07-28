<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinesRequest extends FormRequest
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
            'user_id' => 'sometimes|exists:users,id',
            'borrowing_id' => 'sometimes|exists:borrowings,id',
            'amount' => 'sometimes|numeric|min:0',
            'paid_at' => 'nullable|date',
        ];
    }
}
