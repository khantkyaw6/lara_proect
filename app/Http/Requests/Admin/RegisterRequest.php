<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "fullname" => "required|string",
            "email" => "required|email|unique:admins,email",
            "password" => "required",
            "photo" => "nullable"
            //
        ];
    }

    public function messages()
    {
        return [
            "fullname.required" => "Full name is required",
            "fullname.string" => "Full name must be string",
            "email.required" => "Email is required",
            "email.email" => "Must be email",
            "email.unique" => "Email is already exist",
            "password.required" => "Password is required",
            "password.string" => "Password must be string",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "error" => true,
            "message" => "Valiation Errors",
            "data" => $validator->errors()
        ]));
    }
}
