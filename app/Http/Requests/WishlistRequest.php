<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class WishlistRequest extends FormRequest
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
            'border_color' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in([
                'anniversary',
                'wedding',
                'christmas',
                'birth',
                'communion',
                'easter',
                'other'
            ])],
            'expire_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'id' => ['nullable'], // TODO: Vérifier que l'id existe dans la BDD
            'items' => ['required', 'array', 'min:1'],
            'items.comment' => ['required', 'string'],
            'items.link' => ['required', 'string'],
            'items.name' => ['required', 'string', 'max:255'],
            'items.priority' => ['required', 'string', Rule::in([
                'low',
                'medium',
                'high',
                'ultra'
            ]), 'max:255'],
            'line_color' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sharing_type' => ['required', 'string', Rule::in([
                'friends',
                'selection'
            ]), 'max:255'],
            'text_color' => ['required', 'string', 'max:255']
        ];
    }

    protected function failedValidation(Validator $validator)
    {

    }
}
