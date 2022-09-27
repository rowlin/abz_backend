<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected $count = 6;
    protected $total_pages = 2;

    public function test_get_users() : void
    {

        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
        $this->count = $response->getData()->count;
        $this->total_pages = $response->getData()->total_pages;
        $response->assertJsonStructure([
            'success',
            'page',
            'total_pages',
            'total_users',
            'count',
            'links'	=> [
                'next_url',
                'prev_url'
            ],
            'users' => []
        ]);
    }

    public function test_max_page_wrong() : void
    {
        $total = $this->total_pages+1 ;
        $response = $this->get("/api/v1/users?count=$this->count&page=$total");
        $response->assertStatus(404);
        $response->assertExactJson(['success' => false , 'message' => 	"Page not found"]);
        $response->assertJsonStructure([
            'success',
            'message'
            ]);
    }

    public function test_page_value_wrong() : void
    {
        $response = $this->get("/api/v1/users?count=$this->count&page=s$this->total_pages");
        $response->assertStatus(422);
        $response->assertExactJson(['success' => false , 'message' => "Validation failed" , 'fails' => ['page' => [ 0 => "The page must be an integer."]] ]);
    }

    public function test_page_value_is_0() : void
    {
        $response = $this->get("/api/v1/users?count=$this->count&page=0");
        $response->assertStatus(422);
        $response->assertExactJson(['success' => false , 'message' => "Validation failed" , 'fails' => ['page' => [ 0 => "The page must be at least 1."]] ]);
    }

    public function test_count_value_wrong() : void
    {
        $response = $this->get("/api/v1/users?count=s$this->count&page=$this->total_pages");
        $response->assertStatus(422);
        $response->assertExactJson(['success' => false , 'message' => "Validation failed" , 'fails' => ['count' => [ 0 => "The count must be an integer."]] ]);
    }

    public function test_has_offset_value() : void
    {
        $response = $this->get("/api/v1/users?count=$this->count&page=$this->total_pages&offset=5");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success' , 'users'=> []
        ]);
    }

    public function test_has_offset_value_wrong(): void
    {
        $response = $this->get("/api/v1/users?count=$this->count&page=$this->total_pages&offset=s5");
        $response->assertStatus(422);
        $response->assertExactJson(['success' => false , 'message' => "Validation failed" , 'fails' => ['offset' => [ 0 => "The offset must be an integer."]] ]);
    }

}
