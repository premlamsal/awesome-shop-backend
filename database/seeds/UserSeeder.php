<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => Str::random(5),
            'lastname' => Str::random(5),
            'email' => admin.'@gmail.com',
            'password' => Hash::make('password'),
            'withDrawRequest'=>'0',
            'balance'=>0,
            'user_type'=>'admin'
        ]);
        DB::table('users')->insert([
            'firstname' => Str::random(5),
            'lastname' => Str::random(5),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'withDrawRequest'=>'0',
            'balance'=>0,
            'user_type'=>'customer'
        ]);
    }
}
