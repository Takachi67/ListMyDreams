<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * Prepare for validation
     */
    protected function prepareForValidation()
    {
        if ($this->expire_at && str_contains($this->expire_at, 'T')) {
            $this->merge([
                'expire_at' => Carbon::createFromFormat('Y-m-d\TH:i', $this->expire_at)
            ]);
        }
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
            'expire_at' => ['nullable'],
            'id' => ['nullable'], // TODO: Vérifier que l'id existe dans la BDD
            'items' => ['required', 'array', 'min:1'],
            'items.*.comment' => ['nullable', 'string'],
            'items.*.link' => ['required', 'string', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.priority' => ['required', 'string', Rule::in([
                'low',
                'medium',
                'high',
                'ultra'
            ]), 'max:255'],
            'line_color' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sharing_type' => ['required', 'string', Rule::in([
                'friends',
                'with_link'
            ]), 'max:255'],
            'text_color' => ['required', 'string', 'max:255']
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'border_color.max' => __('validation.border_color.max'),
            'border_color.required' => __('validation.border_color.required'),
            'border_color.string' => __('validation.border_color.string'),

            'category.required' => __('validation.category.required'),
            'category.string' => __('validation.category.string'),
            'category.in' => __('validation.category.in'),

            'items.required' => __('validation.items.required'),
            'items.array' => __('validation.items.array'),
            'items.min' => __('validation.items.min'),

            'items.*.comment.string' => __('validation.items.comment.string'),

            'items.*.link.required' => __('validation.items.link.required'),
            'items.*.link.string' => __('validation.items.link.string'),

            'items.*.name.required' => __('validation.items.name.required'),
            'items.*.name.string' => __('validation.items.name.string'),
            'items.*.name.max' => __('validation.items.name.max'),

            'items.*.priority.required' => __('validation.items.priority.required'),
            'items.*.priority.string' => __('validation.items.priority.string'),
            'items.*.priority.in' => __('validation.items.priority.in'),
            'items.*.priority.max' => __('validation.items.priority.max'),

            'line_color.required' => __('validation.line_color.required'),
            'line_color.string' => __('validation.line_color.string'),
            'line_color.max' => __('validation.line_color.max'),

            'name.required' => __('validation.name.required'),
            'name.string' => __('validation.name.string'),
            'name.max' => __('validation.name.max'),

            'sharing_type.required' => __('validation.sharing_type.required'),
            'sharing_type.string' => __('validation.sharing_type.string'),
            'sharing_type.in' => __('validation.sharing_type.in'),

            'text_color.required' => __('validation.text_color.required'),
            'text_color.string' => __('validation.text_color.string'),
            'text_color.max' => __('validation.text_color.max')
        ];
    }
}
