<?php

namespace App\Http\Requests\Admin\Profiles;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Name;
use App\Rules\Email;
use App\Rules\Image;

class ProfileUpdateRequest extends FormRequest
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
        $id = $this->user()->id;

        return [
            'first_name' => ['required', new Name],
            'last_name' => ['required', new Name],
            'email' => ['required', new Email('admins', $id)],
            'image_path' => ['nullable', new Image],
        ];
    }
}
