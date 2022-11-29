<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Name;
use App\Rules\Email;
use App\Rules\Gender;
use App\Rules\Username;
use App\Rules\Image;
use App\Rules\Date;
use App\Rules\TelephoneNumber;
use App\Rules\MobileNumber;

class UserStoreRequest extends FormRequest
{
    protected $id;

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
        $this->id = $this->route('id');

        return $this->getRules();
    }

    public function messages()
    {
        return [
            'birthday.required' => 'The birthday is an invalid date',
            'birthday.after' => 'The birthday is an invalid date',
        ];
    }

    protected function getRules() {
        $unique = 'unique:users,mobile_number';
        if($this->id) {
            $unique = '';
        } 
        return [
            'first_name' => ['required', new Name],
            'last_name' => ['required', new Name],
            // 'username' => ['required', new Username('users', $this->id)],
            'email' => ['required', new Email('users', $this->id)],
            'image_path' => ['nullable', new Image],
            // 'birthday' => ['required', new Date, 'before:13 years ago', 'after: 129 years ago'],
            // 'gender' => ['required', new Gender],
            // 'telephone_number' => ['nullable', new TelephoneNumber],
            'mobile_number' => ['required', new MobileNumber, $unique],
            'user_type' => ['required'],
        ];
    }
}
