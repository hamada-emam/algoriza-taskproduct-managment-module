<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\User;
use App\Rules\Active;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var User $user */
        $user = auth()->user();

        return $user || $user->hasPermission('create-products');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => [
                'nullable',
                Rule::unique('products', 'code'),
            ],
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'tags' => 'nullable',
            'active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'category_id' => [
                'nullable',
                'exists:categories,id',
                new Active(Category::class),
            ]
        ];
    }
}
