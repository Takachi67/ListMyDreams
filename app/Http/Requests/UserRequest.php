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
}
