<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code'  => $this->code,
            'organization'   => OrganizationResource($this->organization_id),
            'first_name'    => $this->first_name,
            'middle_name' =>    $this->middle_name,
            'surname' =>    $this->surname,
            'birthday'  => $this->birthday,
            'tel'   => $this->tel,
            'address'   => $this->address,
            'service' => ServiceResource($this->service_interest_id),
            'membership_interest'   => $this->membership_interest,
            'like_visited'  => $this->like_visited,
            'workforce_interest'    => $this->workforce_interest,
            'availability'  => $this->availability,
            'photo' =>  $this->photo,
            'created_at'    => $this->created_at,
        ];
    }
}
