<?php

namespace App\Http\Requests\Wishlist;

use Illuminate\Foundation\Http\FormRequest;

class WishlistRequest extends FormRequest
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


        ];
    }

    private function idValidation()
    {
        return [
            'item_id' => ['required', 'exists:wishlist_items,id'],
        ];
    }


}
