<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class NotFoundException extends Exception
{

    /**
     * @return JsonResponse
     */

    public function render(): JsonResponse
    {
        return response()->json([ 'success' => false , 'message' => $this->getMessage() ],404);
    }

}
