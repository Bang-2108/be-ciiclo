<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'percentage'  => 'required|integer|min:0|max:100',
            'category'    => 'required|string|in:frontend,backend,database,tools',
            'is_featured' => 'boolean',
            'sort_order'  => 'integer|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'category.in' => 'Invalid category (frontend, backend, database, tools).',
            'percentage.min' => 'Percentage cannot be less than 0.',
            'percentage.max' => 'Percentage cannot be greater than 100.',
        ];
    }
}