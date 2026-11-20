<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGeneroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** El código del género se normaliza a mayúsculas antes de validar. */
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('codigo'))) {
            $this->merge(['codigo' => strtoupper(trim($this->input('codigo')))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:80', Rule::unique('generos', 'nombre')],
            'codigo' => ['required', 'string', 'regex:/^[A-Z]{3}$/', Rule::unique('generos', 'codigo')],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'edad_minima' => ['required', 'integer', 'min:0', 'max:18'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
