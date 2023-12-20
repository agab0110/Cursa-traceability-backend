<?php

namespace App\Http\Requests\Plant;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantRequest extends FormRequest
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
            'lat' => 'sometimes|required',
            'lng' => 'sometimes|required',
            'woods' => 'required|string|max:255',
            'particle' => 'sometimes|required|numeric',
            'woody_species' => 'required|string|max:255',
            'diameter' => 'required|numeric',
            'height' => 'sometimes|required|numeric',
            'cultivar' => 'sometimes|required|string|max:255',
            'propagation' => 'required|string|max:255',
            'georeferenzial_date' => 'required',
            'notes' => 'nullable|sometimes|string|max:255'
        ];
    }
}
