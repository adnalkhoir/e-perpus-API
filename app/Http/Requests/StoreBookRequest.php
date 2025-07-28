<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\HttpResponseException;
use App\Http\Requests\Validator;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|digits:4',
            'isbn' => 'required|string|unique:books',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

//     protected function failedValidation(Validator $validator)
// {
//     throw new HttpResponseException(response()->json([
//         'message' => 'Validation failed.',
//         'errors' => $validator->errors()
//     ], 422));
// }
}
