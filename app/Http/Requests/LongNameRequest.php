<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LongNameRequest extends Request
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
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'integer' => 'required|integer',
            'image' => 'max:255',
            'thumb' => 'max:255',
            'enum' => 'required|in:one,two',
            'text' => '',
        ];
    }
}
