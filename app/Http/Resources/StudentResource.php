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
            'id' => $this->when(empty($request->throttle), $this->id),
            'surname' => $this->surname,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'matric_number' => $this->matricNo,
            'gender' => $this->gender === 'M' ? 'Male' : 'Female',
            'email' => $this->email,
            'address' => $this->when($this->address, $this->address),
            'phone' => $this->when($this->phone, $this->phone),
            'session_id' => $this->when(empty($request->throttle), $this->session_id),
            'session' => $this->session->year,
            'department' => $this->whenLoaded('department', $this->department->name),
            'created_at' => $this->created_at,
            'updated_at' => $this->when(empty($request->throttle), $this->updated_at),
        ];
    }
}
