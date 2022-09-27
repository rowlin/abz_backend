<?php

namespace Database\Factories;

use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected function getImage(){
        return storage_path('test_images/1.jpg');
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('+380#########'),
            'position_id' => Position::first()->id,
            'photo'  => $this->getImage(), //fake()->image(public_path('/storage/'),640,480, null, false),//
            'registration_timestamp' => Carbon::now()//->timestamp
        ];
    }
}
