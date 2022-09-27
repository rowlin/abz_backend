<?php

namespace App\Http\Resources;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionsResource extends JsonResource
{
    public static $wrap ="";

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = ['success' => true];

        if($this->resource->count() === 0 ){
            $data['success'] = false;
            $data['message'] = 'Positions not found';
            throw new HttpResponseException(response()->json($data, 422));
        }
        $data['positions'] = $this->resource;

        return $data;
    }
}
