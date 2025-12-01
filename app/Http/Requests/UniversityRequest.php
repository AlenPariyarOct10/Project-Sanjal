<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // allow request
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            "name"        => "required|string|max:255",
            "description" => "nullable|string",
            "address"     => "nullable|string|max:255",
            "phone"       => "nullable|string|max:50",
            "email"       => "nullable|email|max:255",

            "logo"        => "nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048",

            "website"     => "nullable|url|max:255",
            "facebook"    => "url|max:255",
            "twitter"     => "nullable|url|max:255",
            "instagram"   => "nullable|url|max:255",
            "youtube"     => "nullable|url|max:255",
            "linkedin"    => "nullable|url|max:255",
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            "name.required" => "University name is required.",
            "name.max"      => "University name cannot exceed 255 characters.",

            "email.email"   => "Please enter a valid email address.",

            "logo.image"    => "Logo must be an image.",
            "logo.mimes"    => "Logo must be a JPG, PNG, JPEG, SVG, or WEBP file.",
            "logo.max"      => "Logo image size must not exceed 2MB.",

            "website.url"      => "Website URL must be valid.",
            "facebook.url"     => "Facebook URL must be valid.",
            "twitter.url"      => "Twitter URL must be valid.",
            "instagram.url"    => "Instagram URL must be valid.",
            "youtube.url"      => "YouTube URL must be valid.",
            "linkedin.url"     => "LinkedIn URL must be valid.",
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
