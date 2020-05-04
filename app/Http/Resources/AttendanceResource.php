<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code'  => $this->code,
            'first_name'    => $this->first_name,
            'middle_name' =>    $this->middle_name,
            'surname' =>    $this->surname,
            'birthday'  => $this->birthday,
            'tel'   => $this->tel,
            'address'   => $this->address,
            'service' => $this->serviceInterest,
            'photo' =>  $this->photo,
        ];
    }
}
