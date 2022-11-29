<?php

namespace App\Http\Requests\API\Documents;

use Illuminate\Foundation\Http\FormRequest;

class DocumentStoreRequest extends FormRequest
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
            'file' => 'required|mimes:jpg,png,heic,docx,pdf,xlxs,pptx|max:2048'
        ];
    }

    public function messages() 
    {
        return [
            'file.max' => 'Please upload a valid image with maximum size of 2mb'
        ];
    }
}
