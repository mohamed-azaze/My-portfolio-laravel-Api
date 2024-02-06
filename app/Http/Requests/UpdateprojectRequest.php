<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateprojectRequest extends FormRequest
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
            'name' => 'required',
            'url' => 'required|url',
            'languages' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Project name is Required',
            'url.required' => 'Project URL is Required',
            'url.url' => 'Example: http://example.com',
            'languages' => 'Languages is required',
        ];
    }
}
