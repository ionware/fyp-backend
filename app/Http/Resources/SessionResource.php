<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->when(empty($request->throttle), $this->id),
            'year' => $this->year,
            'created_at' => $this->created_at,
            'updated_at' => $this->when(empty($request->throttle), $this->updated_at),
        ];
    }
}
