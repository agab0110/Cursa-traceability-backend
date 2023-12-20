<?php

namespace App\Http\Requests\HammeredPlant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHammeredPlantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'hammered' => 'sometimes|required|boolean',
            'diameter' => 'sometimes|required|numeric',
            'height' => 'sometimes|required|numeric',
        ];
    }
}
