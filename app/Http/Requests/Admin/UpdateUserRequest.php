<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
            'required',
            'email',
            Rule::unique(User::class)->ignore($this->route('user', 'email')),
            ],
            'balance' => 'required|numeric|min:0',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,country,general',
            'country_id' => 'required_if:role,country,general|exists:countries,id',
        ];
    }
}
