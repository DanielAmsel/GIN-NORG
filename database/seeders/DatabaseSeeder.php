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
            'modelname' => 'HC35',
            'manufacturer' => 'Worthington',
            'capacity' => '600',
            'number_of_inserts' => '10',
            'number_of_tubes' => '12',
            'number_of_samples' => '5',
        ]);

        DB::table('tank_model')->insert([
            'modelname' => 'HC38',
            'manufacturer' => 'Worthington',
            'capacity' => '600',
            'number_of_inserts' => '10',
            'number_of_tubes' => '12',
            'number_of_samples' => '5',
        ]);

        DB::table('roles')->insert([
            ['role_name' => 'administrator'],
            ['role_name' => 'lab technician'],
            ['role_name' => 'physician'],
            ['role_name' => 'office'],
            ['role_name' => 'Default'],
        ]);

        DB::table('material_types')->insert([
            ['type_of_material' => 'MK'],
            ['type_of_material' => 'TM'],
        ]);

        DB::table('users')->insert(
            [
                'name' => 'admin',
                'email' => 'admin@norg.de',
                'password' => Hash::make('adminpass'),
                'role' => DB::table('roles')->where('role_name', '=', 'administrator')->value('role_name'),
            ]
        );
    }
}
