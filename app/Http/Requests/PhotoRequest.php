<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhotoRequest extends FormRequest
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
        $photoId = $this->route()->photo ? $this->route()->photo : null;
        $ret = [
            'name' => ['required', Rule::unique('photos')->ignore($photoId)],
            'description' => 'required',
        ];

        if (!$photoId){
            $ret['img_path'] = 'bail|required|image';
        }

        return $ret;
    }

    public function messages()
    {
        return [
            'name.required' => 'Il campo name è obbligatorio',
            'name.unique' => 'Il campo name è già presente',
            'description.required' => 'Il campo description è obbligatorio',
            'img_path.required' => 'Il campo immagine è obbligatorio',
        ];
    }
}
