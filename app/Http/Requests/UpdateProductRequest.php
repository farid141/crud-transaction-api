<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'name' => ['string', Rule::unique('products', 'name')->ignore($this->product->id)],
            'price' => 'numeric',
            'unit' => ['string', Rule::in(['pcs', 'kilogram', 'mililiter', 'liter', 'gram', 'ton',])],
            'quantity' => 'numeric',
            'tags' => 'array|exists:tags,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
