<?php

use App\User;
use Faker\Factory as Faker;
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
        $faker_en = Faker::create();
        User::create([
            'name' => 'admin',
            'email' => 'admin@cco.cc',
            'password' => bcrypt('123456'),
//            'password' => '$2y$10$aV5feXbU.0/mHy1L5qIyVOdQO3a9FccqmjVPmOa6bfVQYHX.o0xJW',
        ]);
    }

}
