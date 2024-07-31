<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $k = count($this->segments());
        $endPoint = $this->segment($k);
        switch ($endPoint) {
            case 'create':
                return $this->createValidation();
            case 'update':
                return $this->updateValidation();
//
            case 'delete':
            case 'get':
//
                return $this->idValidation();
//

            default:
                return [];
        }
    }

    private function createValidation()
    {
        return [

            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'inventory' => ['required', 'integer']
        ];
    }

    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:products,id'],
        ];
    }

    private function updateValidation()
    {


        $rules = [
            'id' => ['required', 'exists:products,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'inventory' => ['nullable', 'integer'],
        ];
        return $rules;
    }


}
