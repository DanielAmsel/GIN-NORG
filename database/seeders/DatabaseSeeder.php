<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tank_model')->insert([
            'manufacturer' => 'Worthington',
            'modelname' => 'HC35',
            'capacity' => '600'
        ]);

        DB::table('tank_model')->insert([
            'manufacturer' => 'Worthington',
            'modelname' => 'HC38',
            'capacity' => '600'
        ]);

        DB::table('positions_inserts')->insert(values: [
            ['pos_insert' => '1'],
            ['pos_insert' => '2'],
            ['pos_insert' => '3'],
            ['pos_insert' => '4'],
            ['pos_insert' => '5'],
            ['pos_insert' => '6'],
            ['pos_insert' => '7'],
            ['pos_insert' => '8'],
            ['pos_insert' => '9'],
            ['pos_insert' => '10']
        ]);

        DB::table('positions_tubes')->insert([
            ['pos_tube' => '1'],
            ['pos_tube' => '2'],
            ['pos_tube' => '3'],
            ['pos_tube' => '4'],
            ['pos_tube' => '5'],
            ['pos_tube' => '6'],
            ['pos_tube' => '7'],
            ['pos_tube' => '8'],
            ['pos_tube' => '9'],
            ['pos_tube' => '10'],
            ['pos_tube' => '11'],
            ['pos_tube' => '12']
        ]);

        DB::table('positions_sample')->insert([
            ['pos_sample' => '1'],
            ['pos_sample' => '2'],
            ['pos_sample' => '3'],
            ['pos_sample' => '4'],
            ['pos_sample' => '5']
        ]);

        DB::table('tank_capacity')->insert([
            'number_of_inserts' => '10',
            'number_of_tubes' => '12',
            'number_of_samples' => '5',
        ]);

        DB::table('roles')->insert([
            ['role_name' => 'Administrator'],
            ['role_name' => 'Laborfachkraft'],
            ['role_name' => 'Arzt'],
            ['role_name' => 'Sekretariat'],
            ['role_name' => 'Default'],
        ]);

        DB::table('material_types')->insert([
            ['type_of_material' => 'MK'],
            ['type_of_material' => 'TM'],
        ]);

        DB::table('users')->insert(
            [
                'name' => 'AdminNutzer',
                'email' => 'Platzhalter@Überschreiben.de',
                'password' => Hash::make('Norg2022'),
                'role' => DB::table('roles')->where('role_name', '=', 'Administrator')->value('role_name'),
            ]
        );
    }
}
