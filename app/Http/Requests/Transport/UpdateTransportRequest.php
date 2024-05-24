<?php

namespace App\Http\Requests\Transport;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportRequest extends FormRequest
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
            'shipped' => 'sometimes|boolean',
            'shipped_date' => 'sometimes|date|required_with:shipped',
            'returning' => 'sometimes|boolean',
            'returning_date' => 'sometimes|date|required_with:returning'
        ];
    }
}
