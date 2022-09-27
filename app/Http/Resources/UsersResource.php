<?php

namespace App\Http\Resources;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    public static $wrap ="";

    /**
     * @param \Illuminate\Http\Request $request
     * @return false[]
     * @throws NotFoundException
     */

    public function toArray($request)
    {
        $data = [ 'success' => true ];

        if($this->resource instanceof Collection){
            $data['users'] = $this->resource->all();
        }
        else if($this->resource->items() && sizeof($this->resource->items()) > 0) {
            $data['page'] = $this->resource->currentPage();
            $data['total_pages'] = $this->resource->lastPage();
            $data['total_users'] = $this->resource->total();
            $data['count'] = $this->resource->perPage();
            $data['links'] = [
                "next_url" => !empty($this->resource->nextPageUrl()) ? $this->resource->nextPageUrl() . "&count=" . $this->resource->perPage() : null,
                "prev_url" => !empty($this->resource->previousPageUrl()) ? $this->resource->previousPageUrl() . "&count=" . $this->resource->perPage() : null
             ];

            $data['users'] = $this->resource->items();
        }else{
            throw new NotFoundException("Page not found");
        }

        return $data;
    }
}
