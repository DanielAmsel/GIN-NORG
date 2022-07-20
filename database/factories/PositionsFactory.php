<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PositionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $factory = null;
        return [

              $factory->define(App\Post::class, function ($faker) use ($factory)  {
              return [
                 'user_id' => $factory->create(App\User::class)->id,
                 'title' => $faker->sentence,
                 'body' => $faker->paragraph
              ];
              })


        ];
    }
}
