<?php

namespace App\Http\Requests\Samples;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Varchar;
use App\Rules\Text;
use App\Rules\DateTime;
use App\Rules\Image;

class SampleItemStoreRequest extends FormRequest
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
        $id = $this->route('id');

        $rules = [
            'name' => ['required', new Varchar],
            'description' => ['nullable', new Text],
            'sample_item_id' => 'nullable|exists:sample_items,id',
            'data' => 'nullable',
            'data.*' => 'exists:sample_items,id',
            'date' => ['nullable', new DateTime],
            'dates' => 'nullable',
            'dates.*' => ['nullable', new DateTime],
            'status' => 'nullable',
        ];

        if (!$id) {
            $rules = array_merge($rules, [
                'images' => 'required',
                'images.*' => [new Image],
                'image_path' => ['required', new Image],
            ]);
        } else {
            $rules = array_merge($rules, [
                'images' => 'nullable',
                'images.*' => [new Image],
                'image_path' => ['nullable', new Image],
            ]);
        }

        return $rules;
    }
}
