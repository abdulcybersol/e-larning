<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:16',
            'last_name' => 'required|string|max:16',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',

            // teacher fields
            'teacher.teaching_experience' => 'required_if:role,teacher|string|max:255',
            'teacher.online_teaching_experience' => 'boolean',
            'teacher.fluent_languages' => 'nullable|string|max:255',
            'teacher.availability_hours_per_week'=> 'nullable|integer|min:0',
            'teacher.expected_class_time' => 'nullable|string|max:255',
            'teacher.position_applying_for' => 'nullable|string|max:255',
            'teacher.about' => 'nullable|string',
            'teacher.resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ];
    }
}
