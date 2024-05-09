<?php

namespace App\Http\Requests\HammeredPlant;

use Illuminate\Foundation\Http\FormRequest;

class StoreHammeredPlantRequest extends FormRequest
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
            'lat' => 'sometimes|required',
            'lng' => 'sometimes|required',
            'particle' => 'sometimes|nullable|numeric',
            'woody_species' => 'required|string|max:255',
            'diameter' => 'required|numeric',
            'height' => 'sometimes|nullable|numeric',
            'cultivar' => 'sometimes|nullable|string|max:255',
            'propagation' => 'required|string|max:255',
            'hammered_date' => 'required',
            'notes' => 'nullable|sometimes|string|max:255',
            'hammered' => 'sometimes|required|boolean',
            'forest_id' => 'required|numeric'
        ];
    }
}
