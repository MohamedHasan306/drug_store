<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::create([
             'name' => 'admin',
             'email' => 'admin@example.com',
             'phone_number'=>'0988805250',
             'password'=>'password',
             'role'=>'1',
         ]);


    }
}
