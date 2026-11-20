<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAutorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:120'],
            'nacionalidad' => ['required', 'string', 'max:60'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'correo' => ['nullable', 'email', 'max:160', Rule::unique('autores', 'correo')],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
