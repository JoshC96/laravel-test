<?php

namespace App\Http\Requests\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id
        ]
    }
}