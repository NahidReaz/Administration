<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'sometimes|string|max:191',
            'email' => 'sometimes|string|email|max:191|unique:users,email',
            'image' => 'sometimes|file|image|mimes:jpeg,png,jpg,gif,svg'.$this->user()->id
        ];
    }
}
