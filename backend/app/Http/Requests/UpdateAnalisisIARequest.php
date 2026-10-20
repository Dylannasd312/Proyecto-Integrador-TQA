<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnalisisIARequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resultado' =>
                'sometimes|string|max:100',

            'confianza' =>
                'sometimes|numeric|min:0|max:100',

            'observaciones' =>
                'nullable|string'
        ];
    }
}
