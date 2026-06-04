<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name'               => 'required|string|max:255',
            'role'               => 'required|string|max:255',
            'bio'                => 'required|string',
            'education'          => 'required|string',
            'objective'          => 'required|string',
            'stats_experience'   => 'required|integer|min:0',
            'stats_projects'     => 'required|integer|min:0',
            'stats_internships'  => 'required|integer|min:0',
            'avatar'             => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cv_file'            => 'nullable|file|mimes:pdf|max:5120',
        ];
    }
}