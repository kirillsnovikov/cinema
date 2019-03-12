<?php

use App\Genre;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('Ru_RU');
        $faker_en = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Genre::create([
                'title' => $faker->unique()->word(),
                'slug' => null,
                'published' => (integer) 1,
                'created_by' => (integer) 1
            ]);
        }
    }

}
