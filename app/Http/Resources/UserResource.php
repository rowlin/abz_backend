<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap ="";

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        $data = ['success' => true];

        $data['user'] = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            "position" => $this->resource->position->name,
            "position_id" => $this->resource->position_id,
            "photo" => $this->resource->phone
        ];

        return $data;
    }
}
