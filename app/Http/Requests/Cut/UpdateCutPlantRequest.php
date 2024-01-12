<?php

namespace App\Http\Requests\Cut;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCutPlantRequest extends FormRequest
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
            'cutting' => 'sometimes|required|boolean',
            'cutted' => 'sometimes|required|boolean',
        ];
    }
}
