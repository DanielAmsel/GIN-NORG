<?php

namespace Database\Factories;

use App\Models\StorageTank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Int_;
use Ramsey\Uuid\Type\Integer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sample>
 */
class SampleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //not completely automated, you have to input the corresponding tank_number from the db
        $tankNrCount = ['2'];
        $insertCount = ['1','2','3','4','5','6','7','8','9','10'];
        $tubesCount = ['1','2','3','4','5','6','7','8','9','10','11','12'];
        $sampleCount = ['1','2','3','4','5'];

        $combinationStyle = Arr::crossJoin($tankNrCount, $insertCount,$tubesCount, $sampleCount);

        $combinationUnique = $this->faker->unique->randomElement($combinationStyle);

        $tankNrCoundId = $combinationUnique[0];
        $insertCountId = $combinationUnique[1];
        $tubesCountId = $combinationUnique[2];
        $sampleCountId = $combinationUnique[3];

        return
            [
            'b_number' => $this->faker->numberBetween(1, 1000),
            'pos_tank_nr' => $tankNrCoundId,
            'pos_insert' => $insertCountId,
            'pos_tube' => $tubesCountId,
            'pos_smpl' => $sampleCountId,
            'responsible_person' => 'Platzhalter@Ueberschreiben.de',
            'type_of_material' => 'MK',
            'storage_date' => $this->faker->dateTime,
            'shipping_date' => null,
            ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
