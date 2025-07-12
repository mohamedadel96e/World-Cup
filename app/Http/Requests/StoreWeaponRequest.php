<?php

namespace App\Http\Requests;

use App\Models\Weapon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWeaponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', Weapon::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'base_price' => 'required|integer|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096', // 4MB Max
        ];
    }
}
