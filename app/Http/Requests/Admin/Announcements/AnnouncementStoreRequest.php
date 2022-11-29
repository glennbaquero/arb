<?php

namespace App\Http\Requests\Admin\Announcements;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'image_path' => 'required|mimes:jpeg,jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Title is required.',
            'image_path.required' => 'Banner is required.',
            'image_path.mimes' => 'Banner only accepted file type is .jpeg, .jpg, and .png.'
        ];
    }
}
