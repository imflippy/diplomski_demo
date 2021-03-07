<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //composer require laravel/helpers - potreban da bi mogao
        // str_random(n) da se koristi
        for ($i = 0; $i < 10; $i++) {
            \DB::table('users')->insert([
                'name' => str_random(4),
                'email' => strtolower(str_random(4)).'@gmail.com',
                'password' => \Hash::make('Admin45!')
            ]);
        }  
    }
}
