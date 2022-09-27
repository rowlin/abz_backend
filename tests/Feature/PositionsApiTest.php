<?php

namespace Tests\Feature;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionsApiTest extends TestCase
{

    use RefreshDatabase;

    protected $user_id ;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_positions_get(): void
    {
        $response = $this->get('/api/v1/positions');
        $response->assertStatus(200);
        $response->assertJsonStructure(['success' , 'positions' => [['id' , 'name']]]);
    }

    public function  test_positions_positions_not_found(): void
    {
        Position::query()->update(['status' => false] );
        $response = $this->get('/api/v1/positions');
        $response->assertStatus(422);
        $response->assertJsonStructure(['success' , 'message']);
        $response->assertJson(['success' => false  , 'message' => "Positions not found"]);
        Position::query()->update(['status' => true] );//bad way
    }

}
