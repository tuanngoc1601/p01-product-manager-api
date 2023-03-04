<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $listErrors = $validator->errors()->all();
        $response = new JsonResponse([
            'message' => 'VALIDATION_FAILED',
            'errors' => $listErrors
        ], 422);

        throw new ValidationException($validator, $response);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'category_id' => 'required|numeric',
            'sub_products' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name is already exist',
            'description.required' => 'Description is required',
            'category_id.required' => 'Category is required',
            'category_id.numeric' => 'Category is invalid',
            'sub_products.required' => 'Sub products is required',
        ];
    }
}