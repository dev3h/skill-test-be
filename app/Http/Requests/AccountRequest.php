<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AccountRequest",
 *     title="Account Request",
 *     description="Request body for creating or updating an account",
 *     required={"login", "password", "phone"},
 *     @OA\Property(property="login", type="string", maxLength=20, description="User login name, must be unique"),
 *     @OA\Property(property="password", type="string", format="password", minLength=6, maxLength=40, description="User password"),
 *     @OA\Property(property="phone", type="string", maxLength=20, description="User phone number")
 * )
 */

class AccountRequest extends FormRequest
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
            'login' => 'required|string|max:20|unique:accounts,login,' . $this->route('account'),
            'password' => 'required|string|min:6|max:40',
            'phone' => 'required|string|max:20',
        ];
    }
}
