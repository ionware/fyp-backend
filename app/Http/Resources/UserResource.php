<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'title' => $this->title,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->when(empty($request->throttle), $this->role),
            'token' => $this->when($this->token, $this->token),
            'created_at' => $this->when(empty($request->throttle), $this->created_at),
            'updated_at' => $this->when(empty($request->throttle), $this->updated_at),
        ];
    }
}
