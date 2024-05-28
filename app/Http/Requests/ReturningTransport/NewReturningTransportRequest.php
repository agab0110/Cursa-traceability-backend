<?php

namespace App\Http\Requests\ReturningTransport;

use Illuminate\Foundation\Http\FormRequest;

class NewReturningTransportRequest extends FormRequest
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
            'transport_id' => 'required|integer',
            'notes' => 'sometimes|string',
            'returning_date' => 'required|date'
        ];
    }
}
