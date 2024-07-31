<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            case 'add':
                return $this->createValidation();
            case 'update':
                return $this->updateValidation();
//
            case 'remove':

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

            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],

        ];
    }

    private function idValidation()
    {
        return [
            'item_id' => ['required', 'exists:cart_items,id'],
        ];
    }

    private function updateValidation()
    {


        $rules = [
            'item_id' => ['required', 'exists:cart_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],

        ];
        return $rules;
    }
}
