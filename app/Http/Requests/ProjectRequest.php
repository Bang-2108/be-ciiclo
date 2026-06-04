<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|string|max:255',
            'tech_stack'  => 'required|string', 
            'demo_url'    => 'nullable|url',
            'github_url'  => 'nullable|url',
            'image'       => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}