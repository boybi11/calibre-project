<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfilePasswordUpdateRequest extends Request
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
            'current' => 'required',
            'new' => 'required|confirmed|min:6',
            'new_confirmation' => 'required|min:6'
        ];
    }
}
