<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:120',
            'ingredients' => 'string',
            'price' => 'required|min:1',
            'quantity' => 'integer',
            'sku' => 'required|integer'
        ];
    }

    public function validationData(): array
    {
        $data = $this->all();

        $data['quantity'] = number_format(intval($data['quantity']));
        $data['price'] = number_format(floatval($data['price']), 2);

        return $data;
    }
}
