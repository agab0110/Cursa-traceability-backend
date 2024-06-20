<?php

namespace App\Http\Requests\EstimationModel;

use Illuminate\Foundation\Http\FormRequest;

class NewEstimationModel extends FormRequest
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
        'height' => 'sometimes|numeric',
        'volume' => 'sometimes|numeric',
        'double_diameter' => 'sometimes|numeric',
        'mesure' => 'required|string',
        'formula' => 'required|string',
        'retrurning_parameter' => 'required|string'
        ];
    }
}
