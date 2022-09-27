<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{

    public function getToken(Request $request) :array{
        $token = base64_encode(hash('sha256', $request->ip()  ));
        if(!Session::has($token)){
           Session::put($token , Carbon::now());
        }
        return ['success' => true , 'token'=> $token ];
    }
}
