<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @package App\Http\Resources\V1
 */
class AddressResource extends JsonResource
{
    /**
     * @param Request $request 
     * @return array 
     */
    public function toArray($request): array
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'lead_id' => $this->lead_id
        ];
    }
}
