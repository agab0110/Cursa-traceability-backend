<?php

namespace App\Http\Requests\LogSection;

use Illuminate\Foundation\Http\FormRequest;

class NewLogSectionRequest extends FormRequest
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
            'lot_id' => 'required|integer',
            'log_number' => 'required|integer',
            'section' => 'required|integer'
        ];
    }
}
