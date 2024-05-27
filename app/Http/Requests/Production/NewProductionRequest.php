<?php

namespace App\Http\Requests\Production;

use Illuminate\Foundation\Http\FormRequest;

class NewProductionRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'pre_production_id' => 'required|integer',
            'log_number' => 'required|integer',
            'lot_id' => 'required|integer'
        ];
    }
}
