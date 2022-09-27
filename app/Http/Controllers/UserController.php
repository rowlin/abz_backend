<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserIdRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UsersRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSavedResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Session;

const DEFAULT_COUNT = 5;

class UserController extends Controller
{

    /**
     * @param UsersRequest $request
     * @return UsersResource
     */

    public function getAll(UsersRequest $request) : UsersResource
    {
        if($request->has('offset'))
            $users = User::offset($request->get('offset'))->limit($request->get('count') ?? DEFAULT_COUNT)->get();
        else
            $users = User::paginate($request->get('count') ?? DEFAULT_COUNT);

        return new UsersResource($users);
    }

    /**
     * @param UserIdRequest $request
     * @return UserResource
     */

    public function getById(UserIdRequest $request) : UserResource
    {
        return new UserResource( User::whereId($request->user_id)->with('position')->first());
    }

    /**
     * @param string $message
     * @param int $code
     * @return HttpResponseException
     */

    protected function sendException(string $message , int $code ,bool $status = false): HttpResponseException
    {
        $data['success'] = $status;
        $data['message'] =  $message;
        throw new HttpResponseException(response()->json($data , $code));
    }

    /**
     * @param UserRegisterRequest $request
     * @return UserSavedResource|HttpResponseException
     */
    public function register(UserRegisterRequest $request): UserSavedResource | HttpResponseException
    {
        $data = [];
        if (!Session::has($request->get('token'))) {
            $this->sendException("The token expired.", 401 );
        }else{
            $files = $request->file('photo');
            $path = "/images/" . date('YmdHis') . "." . $files->getClientOriginalExtension();
            \Tinify\setKey(config('tinify.TINIFY_KEY', 'wk7gtsBZzsMSqQW251FfzjL5QnBB1mym'));//for test
            $has_saved = \Tinify\fromBuffer($files->getContent())
                ->resize(array('method' => 'thumb', 'height' => 70, 'width' => 70))
                ->tofile('./storage'.$path);
            if($has_saved) {
                $user = new User();
                $user->name = $request->get('name');
                $user->email = $request->get('email');
                $user->phone = $request->get('phone');
                $user->position_id = $request->get('position_id');
                $user->photo = '/public'.$path;
                $user->registration_timestamp = Carbon::now();
                $user->save();
            }
        }
        if(!isset($user->id)) $this->sendException("Something was wrong.", 500);
        else {
            $data['user_id'] = $user->id ;
        }

        return new UserSavedResource($data);
    }


}
