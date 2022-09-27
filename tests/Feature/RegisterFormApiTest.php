<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class RegisterFormApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function getToken(){
            $token = base64_encode(hash('sha256',  '127.0.0.1' ));
            if(!Session::has($token)){
            Session::put($token , Carbon::now());
            }
         return $token;
    }

    protected function getData($with_image = true ) : array
    {
        $data =  User::factory()->make()->toArray();
        $data['token'] = $this->getToken();
        if($with_image){
            $data['photo'] = UploadedFile::fake()->image('test.jpeg', 80 ,80 );
        }
        return $data;
    }

    public function test_registration_if_token_not_found() : void
    {
        $data =  $this->getData(true);
        unset($data['token']);
        $response = $this->post('/api/v1/users' , $data);
        $response->assertStatus(422);
        $response->assertJsonStructure(['success','message', 'fails' => ['token']]);
    }

    public function test_registration_if_was_expired(): void
    {
        $data =  $this->getData(true);
        Session::forget($data['token']);
        $response = $this->post('/api/v1/users' , $data);
        $response->assertStatus(401);
        $response->assertJsonStructure(['success','message']);
    }

    public function test_registration() : void
    {
        $data = $this->getData(false);
        $data['photo'] = UploadedFile::fake()->image('test.jpeg', 80 ,80 );
        $response = $this->post('/api/v1/users' , $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success','message' , 'user_id']);
        $this->assertDatabaseHas('users', ['name' => $data['name'] , 'email' => $data['email'] , 'phone' => $data['phone']] );
    }

    public function test_registration_wrong_image_width() : void
    {
        $data =  $this->getData(false);
        $data['photo'] = UploadedFile::fake()->image('test.jpeg', 50 ,80 );
        $response = $this->post('/api/v1/users' , $data);
        $response->assertStatus(422);
    }

    public function test_registration_wrong_image_mime() : void
    {
        $data =  $this->getData(false);
        $data['photo'] = UploadedFile::fake()->image('test.png', 100 ,80 );
        $response = $this->post('/api/v1/users' , $data);
        $response->assertStatus(422);
    }

}
