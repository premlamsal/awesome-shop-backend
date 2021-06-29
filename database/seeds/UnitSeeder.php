<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id 1
        DB::table('units')->insert([
            'short_name' => 'pcs',
            'long_name' => 'pieces',
        ]);

        //id 2
        DB::table('units')->insert([
            'short_name' => 'box',
            'long_name' => 'boxes',
        ]);

        //id 3
        DB::table('units')->insert([
            'short_name' => 'sq.ft',
            'long_name' => 'square feet',
        ]);

        //id 4
        DB::table('units')->insert([
            'short_name' => 'kg',
            'long_name' => 'kilogram',
        ]);
     
    }
}
