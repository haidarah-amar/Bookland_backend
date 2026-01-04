<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function Symfony\Component\Translation\t;

class UpdateAuthorRequest extends FormRequest
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
            'name' => [
    'sometimes',
    'required',
    'max:50',
    Rule::unique('authors', 'name')->ignore($this->author),
]

        ];
    }
    // "unique:authors,name,$this->id "
}
