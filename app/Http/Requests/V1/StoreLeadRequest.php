<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class StoreLeadRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required','max:255'],
            'lastName' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => [''], // not specified as needing a rule on the readme
            'electricBill' => ['required', 'integer'],
            'street' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'state' => ['required','max:2', 'min:2'],
            'zip' => ['required','max:5', 'min:5'],
        ];
    }

    /**
     * 
     * @return void 
     * @throws BadRequestException 
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'electric_bill' => $this->electricBill
        ]);
    }
}
