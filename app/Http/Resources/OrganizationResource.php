<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'general_name' => $this->general_name,
            'parish' => $this->parish,
            'logo'  => $this->logo,
            'phone' => $this->phone,
        ];
    }
}
