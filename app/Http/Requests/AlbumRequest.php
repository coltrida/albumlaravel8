<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
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
        $albumId = $this->route()->album ? $this->route()->album->id : null;
        $ret = [
            'album_name' => ['required'],
            'description' => 'required',
        ];

        if ($albumId){
            $ret['album_name'][] = Rule::unique('albums')->ignore($albumId);
        } else {
            $ret['album_thumb'] = 'bail|required|image';
            $ret['album_name'][] = Rule::unique('albums');
        }

        return $ret;
    }

    public function messages()
    {
        return [
            'album_name.required' => 'Il campo album name è obbligatorio',
            'album_name.unique' => 'Il campo album name è già presente',
            'description.required' => 'Il campo description è obbligatorio',
            'album_thumb.required' => 'Il campo immagine name è obbligatorio',
        ];
    }
}
