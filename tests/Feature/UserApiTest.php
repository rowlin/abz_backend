<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{

    use RefreshDatabase;

    protected $user_id ;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user_id =  User::first()->id;
    }

    public function test_get_user(): void
    {
        $response = $this->get("/api/v1/users/$this->user_id");
        $response->assertStatus(200);
        $response->assertJsonStructure(['success' , 'user' => ['id' , 'name' , 'email' , 'phone', 'position' , 'position_id' , 'photo']]);
    }

    public function test_get_user_wrong_id() : void
    {
        $response = $this->get("/api/v1/users/a$this->user_id");
        $response->assertStatus(422);
        $response->assertJson(['success'=> false , 'message' => "Validation failed" ,
            'fails' => ['user_id' =>  [ 0 =>'The user_id must be an integer.']]
        ]);
    }

    public function test_get_user_unused_id() : void
    {
        $response = $this->get("/api/v1/users/999");
        $response->assertStatus(404);
        $response->assertJson(['success'=> false , 'message' =>"The user with the requested identifier does not exist." ,
            'fails'=> ["user_id" => [0 => "User not found"]]]);
    }

}
