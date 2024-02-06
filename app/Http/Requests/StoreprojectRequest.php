<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreprojectRequest extends FormRequest
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
            'full_image' => 'required|image|max:11048|mimes:jpeg,png,jpg,gif',
            'banner_image' => 'required|image|max:11048|mimes:jpeg,png,jpg,gif',
            'languages' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Project name is Required',
            'url.required' => 'Project URL is Required',
            'url.url' => 'Example: http://example.com',
            'full_image.required' => 'Websit Image is required',
            'full_image.max' => 'Max Image Size 10 MB',
            'full_image.mimes' => 'Websit Image Accepted jpeg, png, jpg, gif',
            'banner_image.required' => 'Banner Image is required',
            'banner_image.mimes' => 'Banner Image Accepted jpeg, png, jpg, gif',
            'banner_image.max' => 'Max Image Size 10 MB',
            'languages' => 'Languages is required',
        ];
    }
}
