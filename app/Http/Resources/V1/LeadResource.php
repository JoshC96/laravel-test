<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @package App\Http\Resources\V1
 */
class LeadResource extends JsonResource
{
    /**
     * @param Request $request 
     * @return array|Arrayable|JsonSerializable 
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'electricBill' => $this->electric_bill,
            'address' => $this->whenLoaded('address', function () {
                return $this->address;
            }),
        ];
    }
}