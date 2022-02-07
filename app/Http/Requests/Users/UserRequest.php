<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

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
        if ($this->isMethod('post')){
            return $this->createRules();
        }
        elseif($this->isMethod('put')){
            return $this->updateRules();
        }
    }

    public function createRules() {
        return [
            'name' => ' required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email',
            'password' => 'required|string|min:6',
            'type' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive'
        ];
    }

    public function updateRules(){
        return[
            'name' => 'sometimes|string|max:191',
            'email' => 'sometimes|string|email|max:191',
            'password' => 'sometimes|string|min:6',
            'type' => 'sometimes|in:admin,user',
            'status' => 'sometimes|in:active,inactive',
            'image' => 'sometimes|file|image|mimes:jpeg,png,jpg,gif,svg'. $this->get('id')
        ];
    }
}
