<?php

namespace Database\Seeders;

use App\Models\Sample;
use Database\Factories\SampleFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SamplesSeeder extends Seeder
{
    /**
     * Run the database seeds. You need to manually edit the tank number in the factory!
     *
     * @return void
     */
    public function run()
    {
        Sample::factory(600)->create();
    }
}
