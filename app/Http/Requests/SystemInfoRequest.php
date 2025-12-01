<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SystemInfoRequest extends FormRequest
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
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => 'SystemInfo key is required.',
            'key.string'   => 'SystemInfo key must be a string.',
            'key.max'      => 'SystemInfo key cannot exceed 255 characters.',

            'value.required' => 'SystemInfo value is required.',
            'value.string'   => 'SystemInfo value must be a string.',
            'value.max'      => 'SystemInfo value cannot exceed 255 characters.',

            'status.required' => 'SystemInfo status is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'validation_error',
            'errors' => $validator->errors()
        ], 422));
    }
}
