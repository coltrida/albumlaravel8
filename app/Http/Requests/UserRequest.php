<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route()->user ? $this->route()->user->id : null;
        $ret = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ];

        if ($userId){
            $ret['email'][] = Rule::unique('users')->ignore($userId);
        } else {
            $ret['email'][] = Rule::unique('users');
        }

        return $ret;
    }

    public function messages()
    {
        return [
            'name.required' => 'Il campo name è obbligatorio',
            'email.required' => 'Il campo email è obbligatorio',
            'email.unique' => 'Il campo email è già presente',
            'email.email' => 'Il campo email non ha il formato corretto',
        ];
    }
}
