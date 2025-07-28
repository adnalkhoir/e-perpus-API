<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'isbn' => 'required|string|unique:books,isbn,' . $this->route('book'),
            'stock' => 'required|integer|min:0',
            'cover_image' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
