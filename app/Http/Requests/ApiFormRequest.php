<?php


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiFormRequest extends FormRequest
{

    protected function failedValidation(Validator $validator) {
        $data = [ 'success' => false ,
            'message' => "Validation failed",
            'fails' => $validator->errors()
        ];
        if(key($validator->failed()) === 'user_id' && isset($validator->failed()['user_id']['Exists']) ) {
            $data['message'] = "The user with the requested identifier does not exist.";
            throw new HttpResponseException(response()->json($data, 404));
        }else
            throw new HttpResponseException(response()->json($data, 422));
    }

}
