<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
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
        $method = $this->method();

        // Assumes the only other value is PATCH
        if($method === 'PUT') {
            return [
                'firstName' => ['required', 'max:255'],
                'lastName' => ['required', 'max:255'],
                'email' => ['required', 'email'],
                'phone' => [''], // not specified as needing a rule on the readme
                'electricBill' => ['required', 'integer'],
                'street' => ['required', 'max:255'],
                'city' => ['required', 'max:255'],
                'state' => ['required', 'max:2', 'min:2'],
                'zip' => ['required', 'max:5', 'min:5'],
            ];
        } else {
            return [
                'firstName' => ['sometimes', 'max:255'],
                'lastName' => ['sometimes', 'max:255'],
                'email' => ['sometimes', 'email'],
                'phone' => [''], 
                'electricBill' => ['sometimes', 'integer'],
                'street' => ['sometimes', 'max:255'],
                'city' => ['sometimes', 'max:255'],
                'state' => ['sometimes', 'max:2', 'min:2'],
                'zip' => ['sometimes', 'max:5', 'min:5'],
            ];
        }        
    }

    /**
     * 
     * @return void 
     * @throws BadRequestException 
     */
    protected function prepareForValidation()
    {
        $mergeParams = [];

        if ($this->firstName) {
            $mergeParams['first_name'] = $this->firstName;
        }

        if ($this->lastName) {
            $mergeParams['last_name'] = $this->lastName;
        }

        if ($this->electricBill) {
            $mergeParams['electric_bill'] = $this->electricBill;
        }

        $this->merge($mergeParams);
    }
}
