<?php

namespace App\Http\Requests\Transport;

use Illuminate\Foundation\Http\FormRequest;

class NewTransportRequest extends FormRequest
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
        'plate' => 'required|string|min:7|max:7',
        'driver' => 'required|string|min:2',
        'company' => 'required|string|min:3',
        'lot_id' => 'required|integer',
        'pre_production_id' => 'sometimes|integer',
        'production_id' => 'sometimes|integer',
        'shipping' => 'required|boolean',
        'shipping_date' => 'required|date'
        ];
    }
}
