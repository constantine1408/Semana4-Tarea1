<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Prestamo;
use Illuminate\Validation\Rule;

class UpdatePrestamoRequest extends FormRequest
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
            'fecha_prestamo' => ['required', 'date'],
            'fecha_limite' => ['required', 'date', 'after_or_equal:fecha_prestamo'],
            'estado' => ['required', Rule::in(Prestamo::ESTADOS)],
            'socio_id' => ['required', 'exists:socios,id'],
            'libro_id' => ['required', 'exists:libros,id'],
        ];
    }
}
