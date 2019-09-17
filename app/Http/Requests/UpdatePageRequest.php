<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
            'title' => 'required',
            'uri'   => ['required', 'unique:pages,uri,'.$this->route('page')],
            'type'  => 'required',
            'language' => 'required',
            'name' => 'unique:pages,uri,'.$this->route('page'),
            'content' => 'required'
        ];
    }
}