<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'surname' => $this->surname,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'matric_number' => $this->matricNo,
            'gender' => $this->gender === 'M' ? 'Male' : 'Female',
            'email' => $this->email,
            'address' => $this->when($this->address, $this->address),
            'phone' => $this->when($this->phone, $this->phone),
            'session_id' => $this->session_id,
            'session' => $this->session->year,
        ];
    }
}
