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
            'category.in' => 'Danh mục không hợp lệ (frontend, backend, database, tools).',
            'percentage.min' => 'Phần trăm không được nhỏ hơn 0.',
            'percentage.max' => 'Phần trăm không được lớn hơn 100.',
        ];
    }
}