<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TokenApiTest extends TestCase
{

    public function test_get_token() : void
    {
        $response = $this->get('/api/v1/token');
        $response->assertStatus(200);
        $response->assertJsonStructure(['success' , 'token']);
    }
}
