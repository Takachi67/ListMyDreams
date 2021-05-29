<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nickname' => ['required', 'unique:users,email,' . Auth::user()->getAuthIdentifier()],
            'picture' => ['nullable', 'image'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'nickname.required' => __('validation.nickname.required'),
            'nickname.unique' => __('validation.nickname.unique'),

            'picture.image' => __('validation.picture.image'),

            'password.confirmed' => __('validation.password.confirmed'),
            'password.min' => __('validation.password.min'),
            'password.string' => __('validation.password.string')
        ];
    }
}
